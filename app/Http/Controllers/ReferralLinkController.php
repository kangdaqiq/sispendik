<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralLink;
use Illuminate\Support\Str;

class ReferralLinkController extends Controller
{
    public function index()
    {
        $referralLinks = ReferralLink::withCount('pendaftarans')
            ->latest()
            ->get();

        return view('admin.referral-link.index', compact('referralLinks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Generate kode acak 8 karakter (huruf kapital + angka)
        do {
            $code = strtoupper(\Illuminate\Support\Str::random(8));
        } while (ReferralLink::where('code', $code)->exists());

        ReferralLink::create([
            'code' => $code,
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.referral-link.index')
            ->with('success', "Referral link berhasil dibuat dengan kode: {$code}");
    }

    public function destroy(ReferralLink $referralLink)
    {
        $referralLink->delete();
        return redirect()->route('admin.referral-link.index')
            ->with('success', 'Referral link berhasil dihapus.');
    }
}
