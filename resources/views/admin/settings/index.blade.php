@extends('layouts.admin')
@section('page_title', 'Pengaturan Situs')
@section('title', 'Pengaturan')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-card p-6">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf @method('PUT')

            @php
                $map = $settings->pluck('setting_value', 'setting_key')->toArray();
                $field = fn($key, $default = '') => old("settings.$key", $map[$key] ?? $default);
            @endphp

            <div class="space-y-8">

                {{-- Identitas Brand --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4 pb-2 border-b border-gray-100">Identitas Brand</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="admin-label">Nama Brand</label>
                                <input type="text" name="settings[brand_name]" value="{{ $field('brand_name', 'NFS Web Studio') }}"
                                       class="admin-input">
                            </div>
                            <div>
                                <label class="admin-label">Tagline</label>
                                <input type="text" name="settings[tagline]" value="{{ $field('tagline', 'Website Profesional untuk Bisnis Anda') }}"
                                       class="admin-input">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kontak --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4 pb-2 border-b border-gray-100">Informasi Kontak</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="admin-label">Nomor WhatsApp</label>
                                <input type="text" name="settings[whatsapp]" value="{{ $field('whatsapp', '6288212743260') }}"
                                       class="admin-input" placeholder="6288212743260 (dengan kode negara, tanpa +)">
                            </div>
                            <div>
                                <label class="admin-label">Nomor Telepon (Tampil)</label>
                                <input type="text" name="settings[phone]" value="{{ $field('phone') }}"
                                       class="admin-input" placeholder="0882-1274-3260">
                            </div>
                        </div>
                        <div>
                            <label class="admin-label">Alamat Email</label>
                            <input type="email" name="settings[email]" value="{{ $field('email') }}"
                                   class="admin-input">
                        </div>
                        <div>
                            <label class="admin-label">Pesan Default WhatsApp</label>
                            <input type="text" name="settings[wa_message]" value="{{ $field('wa_message') }}"
                                   class="admin-input" placeholder="Halo NFS Web Studio, saya tertarik membuat website">
                            <p class="text-xs text-gray-400 mt-1">Teks akan di-encode otomatis. Gunakan spasi biasa.</p>
                        </div>
                    </div>
                </div>

                {{-- Sosial Media --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4 pb-2 border-b border-gray-100">Media Sosial</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="admin-label">Instagram URL</label>
                                <input type="url" name="settings[instagram]" value="{{ $field('instagram') }}"
                                       class="admin-input" placeholder="https://instagram.com/akunanda">
                            </div>
                            <div>
                                <label class="admin-label">Facebook URL</label>
                                <input type="url" name="settings[facebook]" value="{{ $field('facebook') }}"
                                       class="admin-input" placeholder="https://facebook.com/halamananda">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SEO --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4 pb-2 border-b border-gray-100">SEO Default</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="admin-label">Meta Description Default</label>
                            <textarea name="settings[meta_description]" rows="3" class="admin-input"
                                      placeholder="Deskripsi singkat untuk mesin pencari...">{{ $field('meta_description') }}</textarea>
                            <p class="text-xs text-gray-400 mt-1">Idealnya 120–160 karakter.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex gap-3 mt-8 pt-5 border-t border-gray-100">
                <button type="submit" class="btn-primary text-sm py-2 px-6">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
