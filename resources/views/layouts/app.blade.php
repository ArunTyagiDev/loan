<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title', 'Capita Loan 24')</title>
	<link rel="icon" type="image/svg+xml" href="{{ asset('assets/logo-mark.svg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f7fb;
            color: #1f2a44;
        }
        .navbar {
            background: linear-gradient(90deg, #0d6efd, #2b54c9);
        }
        .navbar-brand,
        .nav-link {
            color: #fff !important;
        }
		.navbar-brand img {
			height: 32px;
			display: inline-block;
		}
        .hero {
            background: radial-gradient(circle at top left, #e6f0ff, #ffffff);
        }
        footer {
            background-color: #0b1d3a;
            color: #ffffff;
        }
		/* Floating WhatsApp button */
		.whatsapp-float {
			position: fixed;
			right: 18px;
			bottom: 18px;
			z-index: 100000;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			width: 56px;
			height: 56px;
			border-radius: 50%;
			background-color: #25D366;
			color: #fff;
			box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
			text-decoration: none;
			transition: transform 0.2s ease, box-shadow 0.2s ease;
		}
		/* If tawk.to bubble is present, lift the button to avoid overlap */
		.tawk-loaded .whatsapp-float {
			bottom: 88px;
		}
		.whatsapp-float:hover {
			transform: translateY(-2px);
			box-shadow: 0 10px 28px rgba(0, 0, 0, 0.2);
			color: #fff;
		}
		.whatsapp-float svg {
			width: 28px;
			height: 28px;
		}
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
			<a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
				<img src="{{ asset('assets/logo.svg') }}" alt="Capitalloan24" />
				<span class="visually-hidden">Capitalloan24</span>
			</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('loan.eligibility') }}">Eligibility Check</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.login') }}">Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mb-5">
        @if (session('status'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-4">
        <div class="container text-center">
			<p class="mb-0">&copy; {{ date('Y') }} capitalloan24. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

	{{-- Floating WhatsApp Button --}}
	@php
		// Use env phone if available; otherwise fallback to provided number
		$waPhone = env('WHATSAPP_PHONE', '9756862640');
		$waMessage = urlencode('Hello capitalloan24, I would like to know more about loan options.');
		$waDigits = preg_replace('/\D+/', '', $waPhone ?? '');
		if (strlen($waDigits) === 10) {
			$waDigits = '91' . $waDigits;
		}
	@endphp
	<a class="whatsapp-float" href="https://wa.me/{{ $waDigits }}?text={{ $waMessage }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
		<svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
			<path fill="currentColor" d="M19.11 17.38c-.3-.15-1.76-.86-2.03-.96-.27-.1-.47-.15-.67.15-.2.3-.77.95-.94 1.15-.17.2-.35.22-.65.07-.3-.15-1.28-.47-2.44-1.5-.9-.8-1.51-1.8-1.68-2.1-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.57-.48-.5-.67-.51-.17-.01-.37-.01-.57-.01-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.5 0 1.47 1.06 2.9 1.21 3.1.15.2 2.09 3.19 5.06 4.47.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.09 1.76-.72 2.01-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35zM16.07 28C9.4 28 4 22.6 4 15.93 4 9.26 9.4 3.86 16.07 3.86c6.66 0 12.06 5.4 12.06 12.07C28.13 22.6 22.73 28 16.07 28zm6.99-19.06a10.99 10.99 0 0 0-18.77 11.2L4 28l7.99-2.1a10.99 10.99 0 0 0 11.08-17z"/>
		</svg>
	</a>

	{{-- tawk.to chat embed (configurable via env) --}}
	@php
		$tawkProperty = env('TAWKTO_PROPERTY_ID', null);
		$tawkWidget = env('TAWKTO_WIDGET_ID', null);
	@endphp
	@if ($tawkProperty && $tawkWidget)
		<script>
			window.Tawk_API = window.Tawk_API || {};
			window.Tawk_LoadStart = new Date();
			// Optional styling and behavior tweaks
			window.Tawk_API.customStyle = { zIndex: 100000 };
			window.Tawk_API.onLoad = function() {
				document.documentElement.classList.add('tawk-loaded');
			};
		</script>
		<script>
			(function() {
				var s1 = document.createElement("script");
				var s0 = document.getElementsByTagName("script")[0];
				s1.async = true;
				s1.src = "https://embed.tawk.to/{{ $tawkProperty }}/{{ $tawkWidget }}";
				s1.charset = "UTF-8";
				s1.setAttribute("crossorigin", "*");
				s0.parentNode.insertBefore(s1, s0);
			})();
		</script>
	@else
		<script>
			console.warn('tawk.to not initialized: set TAWKTO_PROPERTY_ID and TAWKTO_WIDGET_ID in .env, then run php artisan config:clear');
		</script>
	@endif
</body>
</html>

