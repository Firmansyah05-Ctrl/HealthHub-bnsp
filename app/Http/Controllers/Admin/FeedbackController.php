<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Tampilkan semua feedback dengan algoritma yang dioptimalkan.
     * Menggunakan eager loading selektif dan query optimization.
     */
    public function index(Request $request)
    {
        // Optimized query dengan selective eager loading untuk performance
        $query = Feedback::with([
            'user:id,name,email', // Hanya load field yang diperlukan
            'order:id,total_amount',
            'order.orderItems:id,order_id,product_id,quantity',
            'order.orderItems.product:id,name'
        ]);

        // Enhanced search dengan validasi input
        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            if (strlen($searchTerm) >= 2) { // Minimal 2 karakter untuk efisiensi
                $query->where(function($q) use ($searchTerm) {
                    $q->where('comment', 'like', "%{$searchTerm}%")
                      ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                          $userQuery->where('name', 'like', "%{$searchTerm}%")
                                   ->orWhere('email', 'like', "%{$searchTerm}%");
                      })
                      ->orWhereHas('order.orderItems.product', function($productQuery) use ($searchTerm) {
                          $productQuery->where('name', 'like', "%{$searchTerm}%");
                      });
                });
            }
        }

        // Rating filter dengan validasi
        if ($request->filled('rating') && in_array($request->rating, ['1', '2', '3', '4', '5'])) {
            $query->where('rating', (int)$request->rating);
        }

        // Optimized date range filter
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Pagination dengan ordering konsisten
        $feedbacks = $query->latest('created_at')->paginate(15);

        // Single query untuk semua statistik (lebih efisien)
        $statistics = $this->calculateFeedbackStatistics();

        return view('admin.feedbacks.index', compact('feedbacks', 'statistics'));
    }

    /**
     * Hitung statistik feedback dengan algoritma yang disempurnakan.
     * Menggunakan rumus: (Total Rating Points) ÷ (Total Feedback) untuk rata-rata yang akurat.
     */
    private function calculateFeedbackStatistics()
    {
        // Single query untuk mengambil semua data yang diperlukan
        $stats = Feedback::selectRaw('
            COUNT(*) as total_feedbacks,
            SUM(rating) as total_rating_points,
            SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five_star,
            SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as four_star,
            SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as three_star,
            SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as two_star,
            SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as one_star
        ')->first();

        $totalFeedbacks = $stats->total_feedbacks ?? 0;
        $totalRatingPoints = $stats->total_rating_points ?? 0;

        // Hitung rata-rata rating dengan rumus manual yang jelas:
        // Rata-rata = (Jumlah semua rating) ÷ (Jumlah total feedback)
        $averageRating = 0;
        if ($totalFeedbacks > 0) {
            $averageRating = $totalRatingPoints / $totalFeedbacks;
        }

        // Format display yang tepat
        $displayAverage = $this->formatAverageRating($averageRating);

        return [
            'total_feedbacks' => $totalFeedbacks,
            'total_rating_points' => $totalRatingPoints,
            'average_rating' => $displayAverage,
            'average_rating_raw' => round($averageRating, 2), // Untuk debugging/logging
            'five_star' => $stats->five_star ?? 0,
            'four_star' => $stats->four_star ?? 0,
            'three_star' => $stats->three_star ?? 0,
            'two_star' => $stats->two_star ?? 0,
            'one_star' => $stats->one_star ?? 0,
            
            // Tambahan informasi untuk transparansi
            'calculation_details' => [
                'formula' => 'Total Rating Points ÷ Total Feedback',
                'calculation' => $totalFeedbacks > 0 ? "{$totalRatingPoints} ÷ {$totalFeedbacks} = " . round($averageRating, 2) : 'No data',
            ]
        ];
    }

    /**
     * Format rata-rata rating untuk display yang optimal.
     */
    private function formatAverageRating($average)
    {
        if ($average == 0) return "0";
        
        // Round ke 1 desimal untuk akurasi yang baik
        $rounded = round($average, 1);
        
        // Jika bilangan bulat, tampilkan tanpa desimal
        if ($rounded == floor($rounded)) {
            return number_format($rounded, 0);
        }
        
        // Jika ada desimal, tampilkan dengan 1 desimal
        return number_format($rounded, 1);
    }



    /**
     * Hapus feedback dengan error handling yang lebih baik.
     */
    public function destroy(Feedback $feedback)
    {
        try {
            $userName = $feedback->user->name ?? 'User tidak ditemukan';
            $rating = $feedback->rating;
            
            $feedback->delete();

            return redirect()->route('admin.feedbacks.index')
                           ->with('success', "✅ Feedback dari {$userName} (rating {$rating}★) berhasil dihapus.");
                           
        } catch (\Exception $e) {
            return redirect()->route('admin.feedbacks.index')
                           ->with('error', "❌ Terjadi kesalahan saat menghapus feedback. Silakan coba lagi.");
        }
    }
}
