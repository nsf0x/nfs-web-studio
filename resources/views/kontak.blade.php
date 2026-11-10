@extends('layouts.app')

@section('title', 'Kontak & Konsultasi')
@section('meta_description', 'Hubungi NFS Web Studio untuk konsultasi gratis pembuatan website profesional. Isi formulir dan kami akan segera menghubungi Anda.')

@section('content')
@php
    $wa    = \App\Models\SiteSetting::get('whatsapp', '6288212743260');
    $waMsg = \App\Models\SiteSetting::get('wa_message', 'Halo%20NFS%20Web%20Studio,%20saya%20tertarik%20membuat%20website');
    $phone = \App\Models\SiteSetting::get('phone', '0882-1274-3260');
    $email = \App\Models\SiteSetting::get('email', 'naufalshaflyfawwaz@gmail.com');
    $selectedService = (string) old('service_id', request()->get('layanan', ''));
    $selectedPackage = (string) old('package_id', request()->get('paket', ''));
    $packageGroups = $services->mapWithKeys(fn ($service) => [
        (string) $service->id => $service->packages->map(fn ($package) => [
            'id' => $package->id,
            'name' => $package->name,
            'serviceName' => $service->name,
            'description' => $package->description ?: 'Paket pembuatan website yang disesuaikan dengan kebutuhan bisnis Anda.',
            'price' => $package->price !== null && $package->price > 0
                ? 'Rp' . number_format((float) $package->price, 0, ',', '.')
                : 'Harga dibahas melalui WhatsApp',
            'billingPeriod' => match ($package->billing_period) {
                'monthly' => 'per bulan',
                'yearly' => 'per tahun',
                default => 'sekali bayar',
            },
            'features' => $package->features->pluck('feature')->values(),
            'whatsappUrl' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $wa) . '?text=' . urlencode(
                'Halo NFS Web Studio, saya ingin berkonsultasi tentang layanan '
                . $service->name . ' dan paket ' . $package->name . '.'
            ),
        ])->values(),
    ]);
@endphp

{{-- Hero --}}
<section class="gradient-navy text-white py-20 -mt-16 md:-mt-20 pt-36 md:pt-44">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4">Hubungi Kami</h1>
        <p class="text-gray-300 text-lg max-w-xl mx-auto">
            Konsultasi gratis, tanpa biaya tersembunyi. Tim kami siap membantu mewujudkan website impian Anda.
        </p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Contact Info --}}
            <div class="lg:col-span-1 space-y-6">
                <div>
                    <h2 class="text-xl font-bold text-navy-900 mb-5">Informasi Kontak</h2>
                    <div class="space-y-4">
                        @if($phone)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-accent/10 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Telepon / WhatsApp</p>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="text-navy-900 font-semibold hover:text-accent transition-colors">{{ $phone }}</a>
                            </div>
                        </div>
                        @endif

                        @if($email)
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-accent/10 rounded-xl flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Email</p>
                                <a href="mailto:{{ $email }}" class="text-navy-900 font-semibold hover:text-accent transition-colors break-all">{{ $email }}</a>
                            </div>
                        </div>
                        @endif

                        @if($wa)
                        <div>
                            <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer"
                               class="btn-wa w-full justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                Chat via WhatsApp
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <h3 class="mb-2 font-semibold text-navy-900">Konsultasi Gratis</h3>
                    <p class="mb-4 text-sm leading-relaxed text-gray-600">Ceritakan kebutuhan website Anda melalui WhatsApp atau formulir. Kami akan membahas solusi dan penawaran yang sesuai.</p>
                    @if($wa)
                        <a href="https://wa.me/{{ $wa }}?text={{ $waMsg }}" target="_blank" rel="noopener noreferrer" class="btn-wa w-full justify-center text-sm">Hubungi via WhatsApp</a>
                    @endif
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="card">
                    <h2 class="text-xl font-bold text-navy-900 mb-6">Kirim Pesan</h2>

                    {{-- Success --}}
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <p>{{ session('success') }}</p>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
                        <p class="font-semibold mb-2">Mohon perbaiki kesalahan berikut:</p>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('kontak.store') }}" novalidate>
                        @csrf

                        {{-- Honeypot (hidden) --}}
                        <div class="hidden" aria-hidden="true">
                            <label for="website_url">Website URL (do not fill)</label>
                            <input type="text" name="website_url" id="website_url" value="" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Nama --}}
                            <div>
                                <label for="name" class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}"
                                       class="form-input @error('name') border-red-400 @enderror"
                                       placeholder="Nama Anda" required autocomplete="name">
                                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="form-label">Email <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                       class="form-input @error('email') border-red-400 @enderror"
                                       placeholder="email@contoh.com" required autocomplete="email">
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Telepon --}}
                            <div>
                                <label for="phone" class="form-label">Nomor Telepon / WhatsApp</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                       class="form-input @error('phone') border-red-400 @enderror"
                                       placeholder="08xx-xxxx-xxxx" autocomplete="tel">
                                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Perusahaan --}}
                            <div>
                                <label for="company" class="form-label">Nama Perusahaan / Usaha</label>
                                <input type="text" id="company" name="company" value="{{ old('company') }}"
                                       class="form-input @error('company') border-red-400 @enderror"
                                       placeholder="Nama bisnis Anda (opsional)" autocomplete="organization">
                                @error('company')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Layanan --}}
                            <div x-data="{
                                selectedService: @js($selectedService),
                                selectedPackage: @js($selectedPackage),
                                packageGroups: @js($packageGroups),
                                selectedPackageInfo() {
                                    return (this.packageGroups[this.selectedService] || [])
                                        .find(package => String(package.id) === String(this.selectedPackage));
                                }
                            }">
                                <label for="service_id" class="form-label">Layanan yang Diminati</label>
                                <select id="service_id" name="service_id"
                                        class="form-select @error('service_id') border-red-400 @enderror"
                                        x-model="selectedService"
                                        @change="selectedPackage = ''">
                                    <option value="">— Pilih Layanan —</option>
                                    @foreach($services as $svc)
                                        <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                                <label for="package_id" class="form-label mt-4">Paket yang Diminati</label>
                                <select id="package_id" name="package_id"
                                        class="form-select @error('package_id') border-red-400 @enderror"
                                        x-model="selectedPackage"
                                        :disabled="!selectedService">
                                    <option value="">— Pilih Paket —</option>
                                    <template x-for="package in (packageGroups[selectedService] || [])" :key="package.id">
                                        <option :value="String(package.id)" x-text="package.name"></option>
                                    </template>
                                </select>
                                @error('package_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                                <div x-cloak x-show="selectedPackageInfo()"
                                     class="mt-5 rounded-xl border border-blue-100 bg-blue-50 p-5">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-accent"
                                       x-text="selectedPackageInfo()?.serviceName"></p>
                                    <div class="mt-1 flex flex-wrap items-baseline justify-between gap-2">
                                        <h3 class="font-bold text-navy-900" x-text="selectedPackageInfo()?.name"></h3>
                                        <p class="font-bold text-navy-900">
                                            <span x-text="selectedPackageInfo()?.price"></span>
                                            <span class="text-xs font-normal text-gray-500" x-text="selectedPackageInfo()?.billingPeriod"></span>
                                        </p>
                                    </div>
                                    <p class="mt-2 text-sm leading-6 text-gray-600" x-text="selectedPackageInfo()?.description"></p>
                                    <p class="mt-2 text-xs leading-5 text-gray-500">
                                        Detail kebutuhan dan transaksi dilanjutkan melalui WhatsApp.
                                    </p>
                                    <ul class="mt-3 space-y-1.5">
                                        <template x-for="feature in (selectedPackageInfo()?.features || [])" :key="feature">
                                            <li class="flex gap-2 text-xs text-gray-600">
                                                <span class="text-green-600" aria-hidden="true">✓</span>
                                                <span x-text="feature"></span>
                                            </li>
                                        </template>
                                    </ul>
                                    <a :href="selectedPackageInfo()?.whatsappUrl"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn-wa mt-5 w-full justify-center text-sm">
                                        Lanjutkan konsultasi via WhatsApp
                                    </a>
                                </div>
                            </div>

                            {{-- Budget --}}
                            <div>
                                <label for="budget_range" class="form-label">Kisaran Budget</label>
                                <select id="budget_range" name="budget_range"
                                        class="form-select @error('budget_range') border-red-400 @enderror">
                                    <option value="">— Pilih Kisaran —</option>
                                    <option value="< 1 Juta" {{ old('budget_range') === '< 1 Juta' ? 'selected' : '' }}>Di bawah Rp 1.000.000</option>
                                    <option value="1-3 Juta" {{ old('budget_range') === '1-3 Juta' ? 'selected' : '' }}>Rp 1.000.000 – Rp 3.000.000</option>
                                    <option value="3-5 Juta" {{ old('budget_range') === '3-5 Juta' ? 'selected' : '' }}>Rp 3.000.000 – Rp 5.000.000</option>
                                    <option value="5-10 Juta" {{ old('budget_range') === '5-10 Juta' ? 'selected' : '' }}>Rp 5.000.000 – Rp 10.000.000</option>
                                    <option value="> 10 Juta" {{ old('budget_range') === '> 10 Juta' ? 'selected' : '' }}>Di atas Rp 10.000.000</option>
                                    <option value="Fleksibel" {{ old('budget_range') === 'Fleksibel' ? 'selected' : '' }}>Fleksibel / Belum tahu</option>
                                </select>
                                @error('budget_range')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Pesan --}}
                        <div class="mt-5">
                            <label for="message" class="form-label">Ceritakan Kebutuhan Anda <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" rows="5"
                                      class="form-textarea @error('message') border-red-400 @enderror"
                                      placeholder="Ceritakan tentang bisnis Anda, website yang diinginkan, fitur yang dibutuhkan, timeline, dll..."
                                      required>{{ old('message') }}</textarea>
                            @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Privacy Agree --}}
                        <div class="mt-5">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="privacy_agree" value="1"
                                       class="mt-1 w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent"
                                       {{ old('privacy_agree') ? 'checked' : '' }} required>
                                <span class="text-sm text-gray-600">
                                    Saya menyetujui
                                    <a href="{{ route('privasi') }}" target="_blank" class="text-accent hover:underline">Kebijakan Privasi</a>
                                    dan
                                    <a href="{{ route('syarat') }}" target="_blank" class="text-accent hover:underline">Syarat & Ketentuan</a>
                                    NFS Web Studio. <span class="text-red-500">*</span>
                                </span>
                            </label>
                            @error('privacy_agree')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Submit --}}
                        <div class="mt-6">
                            <button type="submit" class="btn-primary w-full sm:w-auto px-10 py-3.5 text-base">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
