@extends("layouts.front.template_front")
@php
    $setting = \App\Models\Setting::first();
    $title = "Nous contactez :: ". $setting->name_entreprise;
    $title2 = "Nous contactez" ;
@endphp
@push("css")
 <style>
    :root {
      --soft-beige: #f8f1e9;
      --deep-blue: #2c3e50;
    }

    body {
      /* font-family: 'Inter', sans-serif; */
      background-color: #f8f1e9;
      color: #2c3e50;
    }

    /* h1, h2, h3 {
      font-family: 'Playfair Display', serif;
    } */

    .contact-header {
      background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                  url('https://images.unsplash.com/photo-1518199266791-5375a563f8a8?ixlib=rb-4.0.3&auto=format&fit=crop&q=80') center/cover;
      height: 40vh;
      min-height: 320px;
      display: flex;
      align-items: center;
      color: white;
      text-align: center;
    }

    .info-card {
      background: white;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.08);
      height: 100%;
    }

    .contact-icon {
      font-size: 2.2rem;
      color: #2c3e50;
      margin-bottom: 15px;
    }

    .form-control, .form-select {
      border-radius: 10px;
      padding: 12px 16px;
    }

    .btn-contact {
      background-color: #2c3e50;
      color: white;
      border-radius: 50px;
      padding: 14px 40px;
      font-size: 1.1rem;
      transition: all 0.3s;
    }

    .btn-contact:hover {
      background-color: #34495e;
      transform: scale(1.05);
    }

    .whatsapp-btn {
      background-color: #25D366;
      color: white;
    }
  </style>
@endpush


@section("container")
@include("layouts.front.header",['setting'=>$setting])
<!-- HEADER -->
  <header class="contact-header">
    <div class="container">
      <h1 class="display-4 fw-bold mb-3">Contactez-nous</h1>
      <p class="lead fs-4">Nous sommes à votre écoute avec bienveillance et discrétion</p>
    </div>
  </header>

  <div class="container py-5">
    <div class="row g-5">

      <!-- COLONNE GAUCHE : Informations de contact -->
      <div class="col-lg-5">
        <div class="info-card">
          <h3 class="mb-4">Nos Coordonnées</h3>

          <div class="d-flex mb-4">
            <div class="contact-icon me-3">
              <i class="fas fa-phone"></i>
            </div>
            <div>
              <strong>Téléphone</strong><br>
              <a href="tel:+237{{ $setting->telephone }}" class="text-decoration-none text-dark">+237{{ $setting->telephone }}</a>
            </div>
          </div>

          <div class="d-flex mb-4">
            <div class="contact-icon me-3">
              <i class="fab fa-whatsapp"></i>
            </div>
            <div>
              <strong>WhatsApp</strong><br>
              <a href="https://wa.me/33612345678" target="_blank" class="text-decoration-none text-success">
                +237{{ $setting->telephone }} <span class="badge bg-success" style="color: white !important;padding:10px !important;">Réponse rapide</span>
              </a>
            </div>
          </div>

          <div class="d-flex mb-4">
            <div class="contact-icon me-3">
              <i class="fas fa-envelope"></i>
            </div>
            <div>
              <strong>Email</strong><br>
              <a href="mailto:{{ $setting->email }}" class="text-decoration-none text-dark">
                {{ $setting->email }}
              </a>
            </div>
          </div>

          <div class="d-flex mb-4">
            <div class="contact-icon me-3">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
              <strong>Adresse</strong><br>
              {{ $setting->localisation }}<br>
              {{ $setting->ville }}, Cameroun
            </div>
          </div>

          <div class="d-flex">
            <div class="contact-icon me-3">
              <i class="fas fa-mail-bulk"></i>
            </div>
            <div>
              <strong>Boîte Postale</strong><br>
              BP {{ $setting->bp }}<br>
              {{ $setting->ville }}
            </div>
          </div>

          <hr class="my-4">

          <div class="text-center">
            <a href="https://wa.me/237{{ $setting->telephone_whatsapp }}" target="_blank" class="btn whatsapp-btn btn-lg w-100">
              <i class="fab fa-whatsapp"></i> Nous écrire sur WhatsApp
            </a>
          </div>
        </div>
      </div>

      <!-- COLONNE DROITE : Formulaire -->
      <div class="col-lg-7">
        <div class="info-card">
          <h3 class="mb-4">Envoyez-nous un message</h3>

          <form id="contactForm">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Nom complet <span class="text-danger">*</span></label>
                <input type="text" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Email </label>
                <input type="email" class="form-control" >
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Téléphone <span class="text-danger">*</span></label>
                <div class="input-group">
                  <select class="form-select" style="max-width: 140px;">
                    <option value="+237" selected>+237 (Cameroun)</option>
                    <option value="+33">+33 (France)</option>
                    <option value="+32">+32 (Belgique)</option>
                    <option value="+41">+41 (Suisse)</option>
                    <option value="+1">+1 (Canada)</option>
                  </select>
                  <input type="tel" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Objet <span class="text-danger">*</span></label>
                <select class="form-select" required>
                  <option value="">Choisissez un sujet...</option>
                  <option value="devis">Demande de devis</option>
                  <option value="cercueil">Renseignement sur un cercueil</option>
                  <option value="fleurs">Commande de gerbe / fleurs</option>
                  <option value="marbrerie">Renseignement marbrerie</option>
                  <option value="accompagnement">Accompagnement du deuil</option>
                  <option value="autre">Autre demande</option>
                </select>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">Votre message <span class="text-danger">*</span></label>
              <textarea class="form-control" rows="6" placeholder="Décrivez votre demande..." required></textarea>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-contact btn-lg">
                <i class="fas fa-paper-plane"></i> Nous contacter
              </button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <!-- Carte (optionnel mais très utile) -->
  <div class="container-fluid px-0">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.991441!2d2.292292!3d48.858370!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e296e8b5e1b%3A0x7b8e4c5c5f5e5f5e!2sParis!5e0!3m2!1sfr!2sfr!4v123456789"
            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </div>

@endsection
@push("scripts")

@endpush
