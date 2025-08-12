<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ITED - Soluções educacionais interativas com equipamentos e softwares para escolas, em parceria com prefeituras, Google, Microsoft, Samsung, BenQ, Multilaser, Intel, Epson, Luidia e distribuidor autorizado Lenovo. Acesse nosso sistema de gerenciamento e downloads.">
    <title>ITED - Soluções Educacionais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            position: relative;
        }
        
        /* Hero Section Profissional */
        .hero-section {
            background: linear-gradient(90deg, #ffffff 0%, #c3cfe2 100%);
            padding: 80px 0 60px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23ffffff" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .min-vh-75 {
            min-height: 75vh;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: #1a3c6d;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: #6c757d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .hero-features {
            margin-bottom: 2.5rem;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
            color: #495057;
        }
        
        .hero-buttons {
            margin-bottom: 2rem;
        }
        
        .hero-image {
            position: relative;
            z-index: 2;
        }
        
        .image-card {
            position: relative;
        }
        
        .floating-card {
            position: absolute;
            bottom: -20px;
            right: -20px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .hero-stats {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 40px;
            padding: 30px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .stat-item {
            padding: 0 15px;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.95rem;
            margin: 0;
        }
        
        .navbar {
            background: linear-gradient(90deg, #e6f0fa 0%, #003087 100%);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand img {
            max-height: 100px;
            width: auto;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 400;
        }
        
        .nav-link:hover {
            color: #f0f0f0 !important;
        }
        
        .section-title {
            margin-bottom: 40px;
            text-align: center;
            font-weight: 600;
            color: #1a3c6d;
        }
        
        .card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            background: white;
        }
        
        .card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-img-top {
            height: 300px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        
        .card:hover .card-img-top {
            transform: scale(1.1);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-title {
            color: #1a3c6d;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .card-text {
            color: #6c757d;
            line-height: 1.6;
        }
        
        /* Clientes Section */
        .clients-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .client-item {
            position: relative;
            transition: transform 0.3s ease;
        }
        
        .client-item:hover {
            transform: translateY(-5px);
        }
        
        .client-logo-wrapper {
            position: relative;
            background: white;
            border-radius: 15px;
            padding: 30px 20px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .client-logo-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 123, 255, 0.05) 0%, rgba(0, 196, 180, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .client-logo-wrapper:hover::before {
            opacity: 1;
        }
        
        .client-logo-wrapper:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }
        
        .client-logo {
            max-height: 80px;
            max-width: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 2;
        }
        
        .client-logo-wrapper:hover .client-logo {
            transform: scale(1.05);
        }
        
        .client-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #007bff 0%, #00c4b4 100%);
            color: white;
            padding: 12px;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            z-index: 3;
        }
        
        .client-logo-wrapper:hover .client-overlay {
            transform: translateY(0);
        }
        
        .client-name {
            font-size: 0.9rem;
            font-weight: 600;
            margin: 0;
        }
        
        .client-location {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        .client-stats {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 20px;
            padding: 40px 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card i {
            font-size: 2.5rem;
        }
        
        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            margin: 15px 0 10px;
            color: #1a3c6d;
        }
        
        .stat-card .stat-description {
            color: #6c757d;
            font-size: 0.95rem;
            margin: 0;
        }
        
        /* Floating Instagram Sidebar */
        .social-sidebar {
            position: fixed;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #007bff 0%, #00c4b4 100%);
            border-radius: 0 10px 10px 0;
            padding: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        
        .social-sidebar a {
            display: block;
            color: white;
            font-size: 1.5rem;
            padding: 10px;
            transition: transform 0.3s ease;
        }
        
        .social-sidebar a:hover {
            transform: scale(1.2);
        }
        
        .partner-logos img {
            max-height: 60px;
            margin: 0 20px;
            transition: transform 0.3s ease;
        }
        
        .partner-logos img:hover {
            transform: scale(1.2);
        }
        
        .footer {
            background: #1a3c6d;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
        
        .footer a {
            color: #00c4b4;
            text-decoration: none;
            margin: 0 10px;
        }
        
        .footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #00c4b4 100%);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3 0%, #009a8d 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        }
        
        .btn-outline-primary {
            border: 2px solid #007bff;
            color: #007bff;
            border-radius: 50px;
            padding: 10px 28px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #007bff 0%, #00c4b4 100%);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
        }
        
        .login-section, .download-section {
            background: #ffffff;
            padding: 40px 0;
        }
        
        .form-control.is-valid {
            border-color: #28a745;
            background-image: none;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: none;
        }
        
        #backToTop {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #00c4b4;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        #backToTop:hover {
            background: #009a8d;
        }
        
        /* Robotics Frame Styling */
        .robotics-frame {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 200px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        
        .robotics-frame:hover {
            transform: scale(1.05);
        }
        
        .robotics-frame img {
            width: 100%;
            height: auto;
            cursor: pointer;
        }
        
        .robotics-frame .frame-title {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        /* Video Modal Styling */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .modal-fullscreen .modal-body {
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: black;
        }
        
        .modal-fullscreen .modal-body iframe {
            width: 100%;
            max-width: 800px;
            height: 100%;
            max-height: 450px;
            border: none;
            aspect-ratio: 16 / 9;
        }
        
        /* Media queries para responsividade */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-section {
                padding: 60px 0 40px;
            }
            
            .floating-card {
                bottom: -10px;
                right: -10px;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .clients-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 20px;
            }
            
            .client-logo-wrapper {
                padding: 20px 15px;
            }
            
            .client-logo {
                max-height: 60px;
            }
            
            .stat-card {
                padding: 15px;
            }
            
            .stat-card i {
                font-size: 2rem;
            }
            
            .stat-card .stat-number {
                font-size: 1.8rem;
            }
            
            .social-sidebar {
                top: auto;
                bottom: 70px;
                left: 10px;
            }
            
            .robotics-frame {
                width: 150px;
                bottom: 70px;
                right: 10px;
            }
            
            .robotics-frame .frame-title {
                font-size: 0.8rem;
            }
            
            .modal-fullscreen .modal-body iframe {
                max-height: 360px;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-buttons .btn {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }
            
            .hero-buttons .btn:last-child {
                margin-bottom: 0;
            }
            
            .clients-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
            
            .client-stats {
                padding: 30px 15px;
            }
            
            .robotics-frame {
                width: 120px;
                bottom: 60px;
                right: 10px;
            }
            
            .robotics-frame .frame-title {
                font-size: 0.7rem;
            }
            
            .modal-fullscreen .modal-body iframe {
                max-height: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Instagram Sidebar -->
    <div class="social-sidebar">
        <a href="https://www.instagram.com/itedtecnologia" target="_blank" title="Siga-nos no Instagram">
            <i class="fab fa-instagram"></i>
        </a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="img/ited.png" alt="ITED Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#produtos">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#clientes">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#parcerias">Parcerias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#depoimentos">Depoimentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="..\..\edutec\login.php" data-bs-toggle="modal" data-bs-target="">Sistema</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#downloads">Downloads</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contato">Contato</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Robotics Frame -->
    <div class="robotics-frame" data-bs-toggle="modal" data-bs-target="#roboticsVideoModal">
        <img src="img/robotica2.png" alt="Evento de Robótica Educacional">
        <div class="frame-title">>Abertura da Robótica</div>
    </div>

    <!-- Robotics Video Modal -->
    <div class="modal fade" id="roboticsVideoModal" tabindex="-1" aria-labelledby="roboticsVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roboticsVideoModalLabel">Abertura da Robótica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="https://www.instagram.com/p/DMdsjmjyepU/embed" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section Profissional -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="hero-content">
                        <h1 class="hero-title">Soluções Educacionais <span class="text-primary">Inovadoras</span></h1>
                        <p class="hero-subtitle">Transformamos a educação com equipamentos tecnológicos de ponta e softwares integrados, em parceria com as maiores empresas do mundo.</p>
                        <div class="hero-features">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Equipamentos de última geração</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Software Despertar integrado</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Parcerias globais consolidadas</span>
                            </div>
                        </div>
                        <div class="hero-buttons">
                            <a href="#contato" class="btn btn-primary btn-lg me-3">Entre em Contato</a>
                            <a href="#produtos" class="btn btn-outline-primary btn-lg">Nossos Produtos</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="hero-image">
                        <div class="image-card">
                            <img src="img/despertar.jpeg" alt="Software Despertar" class="img-fluid rounded-3 shadow-lg">
                            <div class="floating-card">
                                <div class="card border-0 shadow">
                                    <div class="card-body text-center">
                                        <h6 class="card-title text-primary mb-1">Software Despertar</h6>
                                        <small class="text-muted">Plataforma Educacional</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-stats">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="stat-item">
                            <h3 class="stat-number">500+</h3>
                            <p class="stat-label">Escolas Atendidas</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="stat-item">
                            <h3 class="stat-number">8</h3>
                            <p class="stat-label">Parceiros Globais</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="stat-item">
                            <h3 class="stat-number">15+</h3>
                            <p class="stat-label">Anos de Experiência</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3" data-aos="fade-up" data-aos-delay="400">
                        <div class="stat-item">
                            <h3 class="stat-number">100%</h3>
                            <p class="stat-label">Satisfação</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Produtos Section -->
    <section id="produtos" class="py-5" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">Nossos Produtos</h2>
            <div class="row">
                <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card">
                        <img src="img/iq.png" class="card-img-top" alt="Equipamento">
                        <div class="card-body">
                            <h5 class="card-title">Equipamentos Tecnológicos</h5>
                            <p class="card-text">Lousas digitais, tablets e computadores projetados para o ambiente escolar, com tecnologia de parceiros como Lenovo, Samsung e BenQ.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card">
                        <img src="img/despertar.jpeg" class="card-img-top" alt="Software Despertar">
                        <div class="card-body">
                            <h5 class="card-title">Software Despertar</h5>
                            <p class="card-text">Plataforma inovadora de aprendizagem interativa, integrada com ferramentas Google, Microsoft e Intel.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="card">
                        <img src="img/lousa.jpeg" class="card-img-top" alt="Soluções Integradas">
                        <div class="card-body">
                            <h5 class="card-title">Soluções Integradas</h5>
                            <p class="card-text">Integração de hardware e software para otimizar a educação, com suporte de parceiros como Epson e Luidia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Clientes Section -->
    <section id="clientes" class="py-5 bg-white" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">Nossos Clientes</h2>
            <p class="text-center mb-5">Orgulhosamente atendemos prefeituras e instituições educacionais em toda a região, transformando a educação através da tecnologia.</p>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="clients-grid">
                        <div class="client-item" data-aos="zoom-in" data-aos-delay="100">
                            <div class="client-logo-wrapper">
                                <img src="img/prefeitura-bayeux.jpg" alt="Prefeitura de Bayeux" class="client-logo">
                                <div class="client-overlay">
                                    <h6 class="client-name">Prefeitura de Bayeux</h6>
                                    <small class="client-location">Bayeux - PB</small>
                                </div>
                            </div>
                        </div>
                        <div class="client-item" data-aos="zoom-in" data-aos-delay="200">
                            <div class="client-logo-wrapper">
                                <img src="img/prefeitura-pitimbu.png" alt="Prefeitura de Pitimbu" class="client-logo">
                                <div class="client-overlay">
                                    <h6 class="client-name">Prefeitura de Pitimbu</h6>
                                    <small class="client-location">Pitimbu - PB</small>
                                </div>
                            </div>
                        </div>
                        <div class="client-item" data-aos="zoom-in" data-aos-delay="300">
                            <div class="client-logo-wrapper">
                                <img src="img/prefeitura-conceicao.jpg" alt="Prefeitura de Conceição" class="client-logo">
                                <div class="client-overlay">
                                    <h6 class="client-name">Prefeitura de Conceição</h6>
                                    <small class="client-location">Conceição - PB</small>
                                </div>
                            </div>
                        </div>
                        <div class="client-item" data-aos="zoom-in" data-aos-delay="400">
                            <div class="client-logo-wrapper">
                                <img src="img/prefeitura-gurinhem.jpg" alt="Prefeitura de Gurinhem" class="client-logo">
                                <div class="client-overlay">
                                    <h6 class="client-name">Prefeitura de Gurinhem</h6>
                                    <small class="client-location">Gurinhem - PB</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <div class="client-stats">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <i class="fas fa-building text-primary mb-2"></i>
                                <h4 class="stat-number">15+</h4>
                                <p class="stat-description">Prefeituras Atendidas</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <i class="fas fa-school text-success mb-2"></i>
                                <h4 class="stat-number">200+</h4>
                                <p class="stat-description">Escolas Equipadas</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-card">
                                <i class="fas fa-users text-info mb-2"></i>
                                <h4 class="stat-number">50.000+</h4>
                                <p class="stat-description">Alunos Beneficiados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Parcerias Section -->
    <section id="parcerias" class="py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">Nossas Parcerias</h2>
            <p class="text-center">Colaboramos com líderes globais e prefeituras para oferecer soluções educacionais de alta qualidade. Somos distribuidores autorizados Lenovo.</p>
            <div class="row mt-4 text-center partner-logos">
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="100">
                    <img src="img/google.png" alt="Google">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="400">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" alt="Microsoft">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="300">
                    <img src="img/samsung.png" alt="Samsung">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="400">
                    <img src="img/benq.jpg" alt="BenQ">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="500">
                    <img src="img/lego.jpg" alt="Lego">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="600">
                    <img src="img/intel.png" alt="Intel">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="700">
                    <img src="img/epson.png" alt="Epson">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="800">
                    <img src="img/jovens.png" alt="Jovens Gênios">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="800">
                    <img src="img/robotis.png" alt="robotis">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="800">
                    <img src="img/lenovo.png" alt="lenovo">
                </div>
                <div class="col-md-3 col-sm-6 mb-4" data-aos="zoom-in" data-aos-delay="800">
                    <img src="img/acer.png" alt="acer">
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login - Sistema de Gerenciamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" onsubmit="validateLogin(event)">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="username" placeholder="Seu usuário" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" placeholder="Sua senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Acessar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Downloads Section -->
    <section id="downloads" class="download-section" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">Downloads de Softwares</h2>
            <p class="text-center">Insira o código fornecido pelo administrador para baixar nossos softwares, incluindo o Despertar.</p>
            <form id="downloadForm" onsubmit="validateDownloadCode(event)">
                <div class="mb-3">
                    <label for="downloadCode" class="form-label">Código de Liberação</label>
                    <input type="text" class="form-control" id="downloadCode" placeholder="Digite o código" required>
                </div>
                <button type="submit" class="btn btn-primary" id="downloadButton" disabled>Verificar e Baixar</button>
            </form>
        </div>
    </section>

    <!-- Depoimentos Section -->
    <section id="depoimentos" class="py-5" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">O Que Nossos Clientes Dizem</h2>
            <div class="row">
                <div class="col-md-6 mb-4" data-aos="fade-right" data-aos-delay="100">
                    <blockquote class="blockquote">
                        <p>"A ITED transformou nossas escolas com o Software Despertar e equipamentos de ponta!"</p>
                        <footer class="blockquote-footer">Prefeitura de São Paulo</footer>
                    </blockquote>
                </div>
                <div class="col-md-6 mb-4" data-aos="fade-left" data-aos-delay="200">
                    <blockquote class="blockquote">
                        <p>"A integração com Google, Microsoft e Lenovo facilitou a gestão e o ensino."</p>
                        <footer class="blockquote-footer">Escola Municipal João Silva</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <!-- Contato Section -->
    <section id="contato" class="py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <h2 class="section-title">Entre em Contato</h2>
            <div class="row">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="100">
                    <p>Envie-nos uma mensagem e nossa equipe entrará em contato em breve.</p>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Mensagem</label>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                    </form>
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                    <h5>Informações de Contato</h5>
                    <p><strong>Telefone:</strong> (11) 1234-5678</p>
                    <p><strong>E-mail:</strong> contato@ited.com.br</p>
                    <p><strong>Endereço:</strong> Rua das Tecnologias, 123 - São Paulo, SP</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 ITED - Soluções Educacionais. Todos os direitos reservados.</p>
            <p><a href="https://www.instagram.com/itedtecnologia" target="_blank">Siga-nos no Instagram</a></p>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" onclick="scrollToTop()">↑</button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Back to top button
        window.onscroll = function() {
            const backToTop = document.getElementById('backToTop');
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                backToTop.style.display = 'flex';
            } else {
                backToTop.style.display = 'none';
            }
        };

        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        // Login validation
        function validateLogin(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (username === 'admin' && password === '123456') {
                alert('Login realizado com sucesso!');
                document.getElementById('loginModal').querySelector('.btn-close').click();
            } else {
                alert('Usuário ou senha incorretos!');
            }
        }

        // Download validation
        function validateDownloadCode(event) {
            event.preventDefault();
            const code = document.getElementById('downloadCode').value;
            
            if (code === 'ITED2024') {
                alert('Código válido! Iniciando download...');
                // Aqui você pode adicionar a lógica de download
            } else {
                alert('Código inválido! Verifique com o administrador.');
            }
        }

        // Enable download button when code is entered
        document.getElementById('downloadCode').addEventListener('input', function() {
            const button = document.getElementById('downloadButton');
            button.disabled = this.value.length === 0;
        });
    </script>
</body>
</html>