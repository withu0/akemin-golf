<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ログイン — {{ config('site.brand_ja') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho:wght@500;600;700&family=Noto+Sans+JP:wght@300;400;500&family=Cormorant+Garamond:ital@1&family=Jost:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen grid place-items-center bg-[var(--color-sumi)] grain-dark text-[var(--color-paper)] p-6">

    <div class="w-full max-w-sm">
        <div class="text-center mb-10">
            <x-logo variant="center" tone="gold" class="mb-2" />
            <p class="eyebrow before:hidden !text-white/40 mt-2">Studio Login</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 border border-[var(--color-shu)]/50 text-[var(--color-gold-soft)] px-4 py-3 text-sm rounded-lg text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.attempt') }}" class="space-y-6">
            @csrf
            <div>
                <label class="field-label !text-white/50" for="email">メールアドレス</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="admin-input mt-2 !bg-white/5 !border-white/15 !text-white">
            </div>
            <div>
                <label class="field-label !text-white/50" for="password">パスワード</label>
                <input id="password" name="password" type="password" required
                       class="admin-input mt-2 !bg-white/5 !border-white/15 !text-white">
            </div>
            <label class="flex items-center gap-2 text-sm text-white/60">
                <input type="checkbox" name="remember" class="accent-[var(--color-gold)]"> ログイン状態を保持
            </label>
            <button class="btn btn-gold w-full justify-center">ログイン</button>
        </form>

        <p class="text-center mt-8"><a href="{{ route('home') }}" class="text-xs text-white/40 hover:text-white tracking-widest uppercase font-[var(--font-label)]">← サイトへ戻る</a></p>
    </div>

</body>
</html>
