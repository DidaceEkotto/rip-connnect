@extends("layouts.front.template_front")
@php
    $setting = \App\Models\Setting::first();
    $title = "Avis et décès :: ". $setting->name_entreprise;
    $title2 = "Avis et décès" ;
@endphp
@push("css")
 <!-- Flatpickr CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<!-- Select2 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<!-- Custom CSS for enhancements -->
	<style>
		/* Hero Section Redesign */
		.hero-section {
			position: relative;
			background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
			padding: 5rem 0;
			overflow: hidden;
		}
		.hero-section::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: url('https://www.pompesfunebresdefrance.ci/img/parallax/avis-deces-bougie.jpg') center/cover no-repeat;
			opacity: 0.2;
			z-index: 0;
		}
		.hero-section .container {
			position: relative;
			z-index: 2;
		}
		.hero-title {
			font-size: 3.5rem;
			font-weight: 700;
			color: #fff;
			text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
			margin-bottom: 1rem;
		}
		.hero-subtitle {
			font-size: 1.2rem;
			color: rgba(255,255,255,0.9);
			line-height: 1.6;
		}

		/* Search & Filters Section */
		.filters-section {
			background: #fff;
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.1);
			padding: 2rem;
			margin-top: -3rem;
			position: relative;
			z-index: 10;
		}
		.filter-group {
			margin-bottom: 1rem;
		}
		.filter-group label {
			font-weight: 600;
			color: #333;
			margin-bottom: 0.5rem;
			display: block;
		}
		.filter-group .form-control,
		.filter-group .select2-container {
			border-radius: 10px;
			border: 1px solid #e0e0e0;
			padding: 0.6rem 1rem;
			transition: all 0.3s ease;
		}
		.filter-group .form-control:focus,
		.filter-group .select2-container--default .select2-selection--single:focus {
			border-color: #d4af37;
			box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
		}
		.btn-filter {
			background: #d4af37;
			color: #1a1a2e;
			border: none;
			padding: 0.8rem 2rem;
			border-radius: 50px;
			font-weight: 600;
			transition: all 0.3s ease;
			margin-top: 1.8rem;
		}
		.btn-filter:hover {
			background: #c5a42e;
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(212,175,55,0.3);
		}
		.btn-reset {
			background: #6c757d;
			color: #fff;
			border: none;
			padding: 0.8rem 2rem;
			border-radius: 50px;
			font-weight: 600;
			transition: all 0.3s ease;
			margin-top: 1.8rem;
			margin-left: 0.5rem;
		}
		.btn-reset:hover {
			background: #5a6268;
			transform: translateY(-2px);
		}

		/* Cards Redesign */
		/* .post-item {
			margin-bottom: 30px;
            border: 2px solid red !important;
		} */
		.team-member {
			background: #fff;
			border-radius: 15px;
			overflow: hidden;
			box-shadow: 0 5px 20px rgba(0,0,0,0.08);
			transition: all 0.3s ease;
			height: 100%;

		}
		.team-member:hover {
			transform: translateY(-5px);
			box-shadow: 0 15px 35px rgba(0,0,0,0.15);
		}
		.team-image {
			position: relative;
			overflow: hidden;
		}
		.team-image div {
			transition: transform 0.5s ease;
		}
		.team-member:hover .team-image div {
			transform: scale(1.05);
		}
		.team-desc {
			padding: 5px !important;
			text-align: center;
		}
		.team-desc h3 {
			font-size: 1.3rem;
			font-weight: 700;
			margin-bottom: 5px !important;
			color: #1a1a2e;
		}
		.team-desc span {
			display: inline-block;
			background: #f8f9fa;
			padding: 0.3rem 1rem;
			border-radius: 50px;
			font-size: 0.85rem;
			color: #d4af37;
			font-weight: 600;
			margin-bottom: 1rem;
		}
		.team-desc p {
			color: #6c757d;
			font-size: 0.9rem;
			margin-bottom: 1.5rem;
		}
		.btn-consulter {
			background: transparent;
			border: 2px solid #d4af37;
			color: #d4af37;
			padding: 0.5rem 1.5rem;
			border-radius: 50px;
			font-weight: 600;
			transition: all 0.3s ease;
		}
		.btn-consulter:hover {
			background: #d4af37;
			color: #1a1a2e;
			transform: translateX(5px);
		}

		/* No results message */
		.no-results {
			text-align: center;
			padding: 3rem;
			background: #f8f9fa;
			border-radius: 15px;
			margin-top: 2rem;
		}
		.no-results i {
			font-size: 3rem;
			color: #d4af37;
			margin-bottom: 1rem;
		}

		/* Responsive */
		@media (max-width: 768px) {
			.hero-title {
				font-size: 2rem;
			}
			.filters-section {
				margin-top: -2rem;
				padding: 1.5rem;
			}
			.btn-filter, .btn-reset {
				width: 100%;
				margin-top: 0.5rem;
			}
			.btn-reset {
				margin-left: 0;
			}
		}

		/* Select2 custom styling */
		.select2-container--default .select2-selection--single {
			height: auto;
			padding: 0.6rem 1rem;
			border-radius: 10px;
			border: 1px solid #e0e0e0;
		}
		.select2-container--default .select2-selection--single .select2-selection__rendered {
			line-height: 1.5;
			color: #495057;
		}
		.select2-container--default .select2-selection--single .select2-selection__arrow {
			height: 100%;
			right: 10px;
		}

		/* Flatpickr custom styling */
		.flatpickr-calendar {
			border-radius: 15px;
			box-shadow: 0 10px 30px rgba(0,0,0,0.15);
		}
		.flatpickr-day.selected {
			background: #d4af37;
			border-color: #d4af37;
		}
	</style>
@endpush


@section("container")
@include("layouts.front.header",['setting'=>$setting])
<!-- New Hero Section -->
		<section class="hero-section">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<h1 class="hero-title">
                            Consultez les avis de décès
                        </h1>
						<p class="hero-subtitle">
                            En ces moments de deuil, retrouvez les informations relatives aux cérémonies funéraires dans toutes les villes du pays. Rendez hommage à vos proches disparus, exprimez votre soutien aux familles en laissant un message de condoléances et accompagnez-les dans cette épreuve par un geste de compassion, notamment en faisant livrer des fleurs sur le lieu de la cérémonie.
Parce que chaque vie mérite d'être honorée et chaque souvenir préservé.
                        </p>
					</div>
				</div>
			</div>
		</section>

        @livewire('dece.list-deces',['deces' => $deces, 'page'=>request()->fullUrl()])


@endsection
@push("scripts")
   <!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script>
		$(document).ready(function() {
			// Initialize Select2
			$('#search-city').select2({
				placeholder: "Toutes les villes",
				allowClear: true,
				width: '100%'
			});

			// Initialize Flatpickr
			flatpickr("#search-date", {
				dateFormat: "d/m/Y",
				locale: "fr",
				altInput: true,
				altFormat: "j F Y",
				allowInput: true
			});


		});
	</script>
@endpush
