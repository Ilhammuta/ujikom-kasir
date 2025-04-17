<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function cari(Request $request)
    {
        $telp = $request->telp;
    
        // Cari member berdasarkan nomor telepon
        $member = Member::where('telp', $telp)->first();
    
        // Kalau nggak ada, buat baru
        if (!$member) {
            $member = Member::create([
                'name' => 'Member Baru', // atau bisa disesuaikan nanti di frontend
                'telp' => $telp,
                'points' => 0,
            ]);
        }
    
        return response()->json([
            'nama' => $member->name,
            'poin' => $member->poin,
            'pernah_belanja' => $member->penjualans()->exists()
        ]);
    }
    
}
