<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OTPVerificationController extends Controller
{
    /**
     * Tampilkan halaman verifikasi OTP
     */
    public function showVerifyForm()
    {
        $user = Auth::user();

        // Jika user sudah terverifikasi, redirect ke dashboard
        if ($user && $user->email_verified_at) {
            return redirect()->route('dashboard')
                ->with('success', 'Email Anda sudah terverifikasi.');
        }

        return view('auth.verify-otp');
    }

    /**
     * Kirim OTP ke email user
     */
    public function sendOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Jika sudah terverifikasi
        if ($user->email_verified_at) {
            return redirect()->route('dashboard')
                ->with('success', 'Email Anda sudah terverifikasi.');
        }

        // Generate OTP
        $otp = $user->generateOtp();

        // Kirim email OTP
        try {
            Mail::send('emails.otp', [
                'otp' => $otp,
                'name' => $user->name
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Kode Verifikasi OTP - LIBRARY MINI');
            });

            Log::info('OTP dikirim ulang ke: ' . $user->email . ' | OTP: ' . $otp);

            return back()->with('success', 'Kode OTP telah dikirim ke email Anda!');
        } catch (\Exception $e) {
            Log::error('Gagal kirim OTP: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengirim OTP. Silahkan coba lagi.');
        }
    }

    /**
     * Verifikasi OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Cek apakah user sudah terverifikasi
        if ($user->email_verified_at) {
            return redirect()->route('dashboard')
                ->with('success', 'Email Anda sudah terverifikasi.');
        }

        // Verifikasi OTP
        if ($user->verifyOtp($request->otp)) {
            return redirect()->route('dashboard')
                ->with('success', 'Email berhasil diverifikasi! Selamat datang di LIBRARY MINI.');
        }

        return back()->with('error', 'Kode OTP salah atau sudah kadaluarsa!');
    }

    /**
     * Kirim ulang OTP
     */
    public function resendOtp(Request $request)
    {
        return $this->sendOtp($request);
    }
}