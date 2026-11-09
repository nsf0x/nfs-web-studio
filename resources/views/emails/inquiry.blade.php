<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Baru dari {{ $inquiry->name }} | NFS Web Studio</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f7fb; margin: 0; padding: 32px 16px; color: #0B1F3A; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(11,31,58,0.10); }
        .header { background: linear-gradient(135deg, #0B1F3A, #1a3666); padding: 32px 36px; }
        .header h1 { margin: 0; color: #fff; font-size: 22px; font-weight: 700; }
        .header p { margin: 8px 0 0; color: #9db5d4; font-size: 14px; }
        .badge { display: inline-block; background: #C9A227; color: #0B1F3A; padding: 4px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; margin-top: 12px; }
        .body { padding: 32px 36px; }
        .field { margin-bottom: 20px; }
        .field-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #6b7280; margin-bottom: 4px; }
        .field-value { font-size: 15px; color: #0B1F3A; font-weight: 500; word-break: break-word; }
        .message-box { background: #f4f7fb; border-radius: 10px; padding: 16px; margin-top: 4px; font-size: 14px; color: #374151; line-height: 1.6; white-space: pre-wrap; }
        .divider { height: 1px; background: #e5e7eb; margin: 24px 0; }
        .cta { background: #2563EB; color: #fff; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block; margin-top: 8px; }
        .footer { background: #f9fafb; padding: 20px 36px; text-align: center; font-size: 12px; color: #9ca3af; border-top: 1px solid #e5e7eb; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 480px) { .grid { grid-template-columns: 1fr; } .header, .body { padding: 24px 20px; } }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📨 Pesan Baru Masuk</h1>
        <p>Ada calon klien yang menghubungi NFS Web Studio melalui formulir kontak</p>
        <span class="badge">STATUS: BARU</span>
    </div>

    <div class="body">
        <div class="grid">
            <div class="field">
                <div class="field-label">Nama</div>
                <div class="field-value">{{ $inquiry->name }}</div>
            </div>
            <div class="field">
                <div class="field-label">Email</div>
                <div class="field-value"><a href="mailto:{{ $inquiry->email }}" style="color: #2563EB;">{{ $inquiry->email }}</a></div>
            </div>
            @if($inquiry->phone)
            <div class="field">
                <div class="field-label">Telepon / WhatsApp</div>
                <div class="field-value"><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" style="color: #16a34a;">{{ $inquiry->phone }}</a></div>
            </div>
            @endif
            @if($inquiry->company)
            <div class="field">
                <div class="field-label">Perusahaan</div>
                <div class="field-value">{{ $inquiry->company }}</div>
            </div>
            @endif
            @if($inquiry->service)
            <div class="field">
                <div class="field-label">Layanan</div>
                <div class="field-value">{{ $inquiry->service->name }}</div>
            </div>
            @endif
            @if($inquiry->package)
            <div class="field">
                <div class="field-label">Paket</div>
                <div class="field-value">{{ $inquiry->package->name }}</div>
            </div>
            @endif
            @if($inquiry->budget_range)
            <div class="field">
                <div class="field-label">Budget</div>
                <div class="field-value">{{ $inquiry->budget_range }}</div>
            </div>
            @endif
            <div class="field">
                <div class="field-label">Waktu Masuk</div>
                <div class="field-value">{{ $inquiry->created_at ? $inquiry->created_at->format('d M Y, H:i') . ' WIB' : '-' }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="field">
            <div class="field-label">Pesan</div>
            <div class="message-box">{{ $inquiry->message }}</div>
        </div>

        <div class="divider"></div>

        <p style="font-size: 14px; color: #6b7280; margin-bottom: 12px;">
            Segera hubungi calon klien ini untuk memberikan kesan pertama yang baik.
        </p>

        @if($inquiry->phone)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}?text={{ urlencode('Halo ' . $inquiry->name . ', terima kasih telah menghubungi NFS Web Studio. Saya ingin mendiskusikan kebutuhan website Anda lebih lanjut.') }}"
           class="cta" style="background: #16a34a; margin-right: 10px;">
            💬 Balas via WhatsApp
        </a>
        @endif
        <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Re: Inquiry dari ' . $inquiry->name) }}" class="cta">
            ✉️ Balas via Email
        </a>
    </div>

    <div class="footer">
        Email ini dikirim otomatis oleh sistem <strong>NFS Web Studio</strong>.<br>
        Jangan reply email ini langsung.
    </div>
</div>
</body>
</html>
