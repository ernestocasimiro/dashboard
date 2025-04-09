<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Colégio Pitruca Camama</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f9fafb;
            min-height: 100vh;
        }

        .container {
            display: flex;
            min-height: 100vh;
            max-width: 100%;
            padding: 0;
        }

        /* Login Section */
        .login-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            background-color: white;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }

        .login-container h1 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #1f2937;
        }

        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-container input,
        .select-container select {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3.25rem; /* Aumentado o padding-left para 3.25rem */
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-container input:focus,
        .select-container select:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .password-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .forgot-password {
            font-size: 0.875rem;
            color: #3b82f6;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
        }

        .select-container {
            position: relative;
        }

        .select-arrow {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #aaa;
        }

        .login-button {
            width: 100%;
            padding: 0.75rem;
            background-color: #3b82f6;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-button:hover {
            background-color: #2563eb;
        }

        .alert {
            margin-bottom: 1.5rem;
            border-radius: 0.5rem;
        }

        /* Slideshow Section */
        .slideshow-section {
            flex: 1;
            display: none;
            position: relative;
            overflow: hidden;
            background-color: #1a365d;
        }

        .slideshow-container {
            height: 100%;
            width: 100%;
            position: relative;
        }

        /* Desfoque azul por cima do slideshow */
        .slideshow-container::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(37, 99, 235, 0.3);
            z-index: 2;
            pointer-events: none;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide.active {
            opacity: 1;
            z-index: 1;
        }

        .slide img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
        }

        .slide-content {
            position: relative;
            z-index: 3;
            color: white;
            text-align: center;
            padding: 2rem;
            max-width: 80%;
        }

        .slide-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .slide-content p {
            font-size: 1.25rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .prev-btn,
        .next-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: white;
            transition: background 0.3s ease;
        }

        .prev-btn:hover,
        .next-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .prev-btn {
            left: 1.5rem;
        }

        .next-btn {
            right: 1.5rem;
        }

        .dots-container {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.75rem;
            z-index: 10;
        }

        .dot {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .dot.active {
            background: white;
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .slideshow-section {
                display: block;
            }
        }

        @media (max-width: 767px) {
            .login-section {
                flex: 1;
            }
            
            .login-container {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Login Form Section -->
        <div class="login-section">
            <div class="login-container">
                <h1>Acessar A Sua Conta</h1>
                <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_GET['error']; ?>
                </div>
                <?php } ?>

                <form class="login-form" method="post" action="req/login.php">
                    <div class="form-group">
                        <label for="uname">Nome de Utilizador</label>
                        <div class="input-container">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input name="uname" type="text" id="uname" placeholder="Digite seu nome de utilizador">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="password-header">
                            <label for="pass">Palavra-Passe</label>
                            <a href="#" class="forgot-password">Esqueceu a Palavra-Passe?</a>
                        </div>
                        <div class="input-container">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </span>
                            <input type="password" id="pass" placeholder="Digite sua palavra-passe" name="pass">
                            <button type="button" class="toggle-password" id="togglePassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="role">Entrar como</label>
                        <div class="select-container">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <select id="role" name="role">
                                <option value="">Selecione uma opção</option>
                                <option value="1">Administrador</option>
                                <option value="2">Professor</option>
                                <option value="3">Encarregado</option>
                            </select>
                            <span class="select-arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </span>
                        </div>
                    </div>
                    
                    <button type="submit" class="login-button" name="login">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                        Entrar
                    </button>
                </form>
                <!-- criar pass secreta/encriptada -->
                <!-- <?php 
                        $pass = 123;
                        $pass = password_hash($pass, PASSWORD_DEFAULT);
                        echo $pass; ?> 
                        -->
            </div>
        </div>
        
        <!-- Slideshow Section -->
        <div class="slideshow-section">
            <div class="slideshow-container">
                <div class="slide active">
                    <div class="slide-content">
                        <h2>Comece Sua Jornada Educacional,</h2>
                        <p>Descubra Um Mundo de Possibilidades</p>
                    </div>
                    <img src="images/estudantes01.jpg" alt="Estudantes na escola">
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <h2>Aprenda, Cresça, Evolua</h2>
                        <p>Educação de Qualidade para o Futuro</p>
                    </div>
                    <img src="images/estudantes02.jpeg" alt="Sala de aula">
                </div>
                
                <div class="slide">
                    <div class="slide-content">
                        <h2>Conectando Alunos e Professores</h2>
                        <p>Uma Comunidade de Aprendizagem</p>
                    </div>
                    <img src="images/estudantes03.jpeg" alt="Estudantes colaborando">
                </div>
                
                <!-- Navigation Arrows -->
                <button class="prev-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="next-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
                
                <!-- Dots Navigation -->
                <div class="dots-container">
                    <span class="dot active" data-slide="0"></span>
                    <span class="dot" data-slide="1"></span>
                    <span class="dot" data-slide="2"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Slideshow functionality
        document.addEventListener('DOMContentLoaded', function() {
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.dot');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            let currentSlide = 0;
            
            // Function to show a specific slide
            function showSlide(index) {
                // Hide all slides
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));
                
                // Show the selected slide
                slides[index].classList.add('active');
                dots[index].classList.add('active');
                currentSlide = index;
            }
            
            // Event listeners for dots
            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const slideIndex = parseInt(this.getAttribute('data-slide'));
                    showSlide(slideIndex);
                });
            });
            
            // Event listeners for arrows
            prevBtn.addEventListener('click', function() {
                currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(currentSlide);
            });
            
            nextBtn.addEventListener('click', function() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            });
            
            // Auto-advance slideshow
            setInterval(function() {
                currentSlide = (currentSlide + 1) % slides.length;
                showSlide(currentSlide);
            }, 5000);
            
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('pass');
            
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
            });
        });
    </script>
    <!-- Bootstrap JS (necessário para o botão de fechar o alerta funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>