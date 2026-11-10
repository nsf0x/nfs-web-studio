@extends('layouts.app')

@section('title', 'Informasi Kontak')
@section('meta_description', 'Informasi telepon, WhatsApp, dan email NFS Web Studio.')

@section('content')
@php
    $wa = preg_replace('/[^0-9]/', '', \App\Models\SiteSetting::get('whatsapp', '6288212743260'));
    $phone = \App\Models\SiteSetting::get('phone', '0882-1274-3260');
    $email = \App\Models\SiteSetting::get('email', 'naufalshaflyfawwaz@gmail.com');
    $waMessage = urlencode('Halo NFS Web Studio, saya ingin bertanya.');
@endphp

<section class="gradient-navy -mt-16 py-20 pt-36 text-white md:-mt-20 md:pt-44">
    <div class="mx-auto max-w-5xl px-4 text-center sm:px-6 lg:px-8">
        <h1 class="mb-4 text-4xl font-extrabold sm:text-5xl">Informasi Kontak</h1>
        <p class="mx-auto max-w-xl text-lg text-gray-300">
            Hubungi NFS Web Studio melalui kanal berikut.
        </p>
    </div>
</section>

<section class="bg-gray-50 py-16">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="card">
            <h2 class="mb-6 text-xl font-bold text-navy-900">Kontak NFS Web Studio</h2>
            <dl class="space-y-6">
                @if($phone)
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-accent/10">
                            <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Telepon</dt>
                            <dd>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="font-semibold text-navy-900 hover:text-accent">
                                    {{ $phone }}
                                </a>
                            </dd>
                        </div>
                    </div>
                @endif

                @if($wa)
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50">
                            <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884"/>
                            </svg>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">WhatsApp · Chat & transaksi</dt>
                            <dd>
                                <a href="https://wa.me/{{ $wa }}?text={{ $waMessage }}" target="_blank" rel="noopener noreferrer" class="font-semibold text-navy-900 hover:text-green-600">
                                    {{ $phone ?: '+' . $wa }}
                                </a>
                            </dd>
                        </div>
                    </div>
                @endif

                @if($email)
                    <div class="flex items-start gap-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-accent/10">
                            <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Email</dt>
                            <dd>
                                <a href="mailto:{{ $email }}" class="break-all font-semibold text-navy-900 hover:text-accent">{{ $email }}</a>
                            </dd>
                        </div>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</section>
@endsection
