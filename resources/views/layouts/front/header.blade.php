 <!-- Header -->
        <header id="header">
            <div class="header-inner">
                <!-- Toggle Menu Mobile -->
                <div class="toolbar__toggle">
                    <button class="hamburger-btn" id="hamburgerBtn" onclick="toggleMobileMenu()">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                </div>

                <!-- Toolbar -->
                <section class="toolbar">
                    <div class="toolbar__container">
                        <div class="toolbar__logo">
                            <a href="{{ route('homePage') }}" title="{{ env('APP_NAME') }}">
                                <img width="120" height="120" src="{{ asset('assets/images/logo.png')}}" class="attachment-medium size-medium" alt="{{ env('APP_NAME') }}" />
                            </a>
                        </div>
                        <div class="toolbar__content">
                            <div class="toolbar__resume">
                                <span class="toolbar__label">À votre service 24H/24 7J/7</span>
                            </div>
                            <div class="toolbar__phone">
                                <span class="toolbar__label"><i class="bi bi-whatsapp"></i> <a href="tel:+{{ $setting->indicatif }}{{ $setting->telephone_whatsapp }}">+{{ $setting->indicatif }}{{ $setting->telephone_whatsapp }}</a></span>
                            </div>
                            {{-- <div class="toolbar__shortcuts invisible-portable">
                                <div class="toolbar__item">
                                    <span class="toolbar__shortcut">
                                        <a href="prendre-rendez-vous.html" target="_self" class="toolbar__a">Prendre rendez-vous</a>
                                    </span>
                                </div>
                                <div class="toolbar__item">
                                    <span class="toolbar__shortcut">
                                        <a href="contact.html" target="_blank" class="toolbar__a">Nous contacter</a>
                                    </span>
                                </div>
                            </div> --}}
                        </div>
                        <div class="toolbar__links d-print-none">
                            {{-- <span class="toolbar__config"> --}}
                            <span class="toolbar__phone">
                                {{-- <a href="devis-en-ligne.html" class="toolbar__a">Devis immédiat en ligne</a> --}}
                                  <span class="toolbar__label"> <a href="mailto:{{ $setting->email }}"><i class="bi bi-envelope-at"></i> {{ $setting->email }}</a></span>
                            </span>
                            {{-- <span class="toolbar__urgence">
                                <a href="urgence-deces.html"><b>URGENCE DÉCÈS&nbsp;&nbsp;<i class="fa fa-mobile-alt"></i>&nbsp;&nbsp;24H/7J</b></a>
                            </span> --}}
                        </div>
                    </div>
                </section>

                <!-- Menu Principal -->
                <div class="container d-print-none">
                    <div id="mainMenu" class="menu-lines menu-onclick menu-center">
                        <div class="container">
                            <nav class="menu_principal">
                                <ul>
                                    <li class="{{ Request::routeIs('homePage') ? 'current': '' }}"><a href="{{ route('homePage') }}">Accueil</a></li>
                                    <li class="dropdown {{ Request::routeIs('deces.*') ? 'current': '' }}">
										<a href="#">Décès
											<i class="icon-chevron-down d-none d-md-inline-block"></i>
										</a>
										<ul class="dropdown-menu">
											<li>
												<a href="{{ route('deces.index') }}">Annonce de décès</a>
											</li>
											<li>
												<a href="">Avis & carnet du jour</a>
											</li>
											<li>
												<a href="">Registre de condoléance</a>
											</li>

											<li>
												<a href="">Ephéméride</a>
											</li>

										</ul>
									</li>
                                    <li class="{{ Request::routeIs('services.*') ? 'current': '' }}"><a href="{{ route('services.index') }}">Services</a></li>
                                    {{-- <li class="{{ Request::routeIs('aides.*') ? 'current': '' }}"><a href="{{ route('aides.index') }}">Aides</a></li> --}}
                                    <li class="dropdown {{ Request::routeIs('pompe.*') ? 'current': '' }}">
										<a href="#">Arts funéraires
											<i class="icon-chevron-down d-none d-md-inline-block"></i>
										</a>
										<ul class="dropdown-menu">
											{{-- <li>
												<a href="{{ route('pompe.index') }}">Pompes funèbres</a>
											</li> --}}
											<li>
												<a href="{{ route('pompe.cercueil') }}">Cercueil</a>
											</li>
											<li>
												<a href="{{ route('pompe.gerbes_fleurs') }}">Gerbes de fleurs</a>
											</li>
											<li>
												<a href="{{ route('pompe.marbrerie') }}">Marbreries</a>
											</li>
											{{-- <li>
												<a href="">Véhicules</a>
											</li> --}}

											{{-- <li>
												<a href="">Morgues</a>
											</li> --}}
											<li>
												<a href="">Rites & Pratiques</a>
											</li>

										</ul>
									</li>
                                    <li class="{{ Request::routeIs('morgue.*') ? 'current': '' }}"><a href="{{ route('morgue.index') }}">Morgues</a></li>

                                    <li class="{{ Request::routeIs('contact.index') ? 'current': '' }}"><a href="{{ route('contact.index') }}">Contact</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>


            </div>
        </header>
        <!-- end: Header -->
