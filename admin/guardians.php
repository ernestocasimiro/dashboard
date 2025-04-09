<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encarregados - Sistema de Gestão Escolar</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .user-dropdown {
      position: relative;
      cursor: pointer;
    }
    
    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 100%;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 4px;
      padding: 8px 0;
      z-index: 1000;
      min-width: 150px;
    }
    
    .dropdown-menu.show {
      display: block;
    }
    
    .dropdown-item {
      padding: 8px 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      color: #333;
      text-decoration: none;
    }
    
    .dropdown-item:hover {
      background-color: #f5f5f5;
    }
  </style>
</head>
<body>
    <div class="container">
    <nav class="sidebar">
          <div class="logo">
              <h2>Pitruca Camama</h2>
          </div>
          <ul class="nav-links">
              <!-- Painel (Visão Geral) -->
              <li data-tab="dashboard">
                  <a href="index.php">
                      <i class="fas fa-tachometer-alt"></i> 
                      <span>Painel</span>
                  </a>
              </li>
              
              <!-- Gestão De Alunos -->
              <li class="has-submenu" data-tab="student-management">
                  <div class="menu-item">
                      <i class="fas fa-user-graduate"></i> 
                      <span>Gestão De Alunos</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu show">
                      <li data-tab="register-students">
                          <a href="students.php">
                              <i class="fas fa-user-plus"></i> 
                              <span>Estudantes</span>
                          </a>
                      </li>
                      <li data-tab="attendance">
                          <a href="attendance.php">
                              <i class="fas fa-calendar-check"></i> 
                              <span>Presença</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Gestão Pedagógica -->
              <li class="has-submenu" data-tab="pedagogical-management">
                  <div class="menu-item">
                      <i class="fas fa-chalkboard"></i> 
                      <span>Gestão Pedagógica</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="classes">
                          <a href="classes.php">
                              <i class="fas fa-users"></i> 
                              <span>Turmas</span>
                          </a>
                      </li>
                      <li data-tab="schedule">
                          <a href="schedule.php">
                              <i class="fas fa-calendar-alt"></i> 
                              <span>Horários</span>
                          </a>
                      </li>
                      <li data-tab="tests">
                          <a href="tests.php">
                              <i class="fas fa-file-alt"></i> 
                              <span>Provas</span>
                          </a>
                      </li>
                      <li data-tab="bulletins">
                          <a href="bulletins.php">
                              <i class="fas fa-file-invoice"></i> 
                              <span>Boletins</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Gestão de Funcionários -->
              <li class="has-submenu" data-tab="staff-management">
                  <div class="menu-item">
                      <i class="fas fa-chalkboard-teacher"></i> 
                      <span>Gestão de Funcionários</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="register-teachers">
                          <a href="teacher.php">
                              <i class="fas fa-user-plus"></i> 
                              <span>Professores/Coordenadores</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Utilizadores -->
              <li class="has-submenu active" data-tab="student-management">
              <li class="has-submenu" data-tab="users">
                  <div class="menu-item">
                      <i class="fas fa-users"></i> 
                      <span>Utilizadores</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu show">
                      <li class="active" data-tab="guardians">
                          <a href="guardians.php">
                              <i class="fas fa-user-friends"></i> 
                              <span>Encarregados</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Comunicação -->
              <li class="has-submenu" data-tab="communication">
                  <div class="menu-item">
                      <i class="fas fa-comments"></i> 
                      <span>Comunicação</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="messages">
                          <a href="messages.php">
                              <i class="fas fa-envelope"></i> 
                              <span>Mensagens</span>
                          </a>
                      </li>
                      <li data-tab="notice-board">
                          <a href="notices.php">
                              <i class="fas fa-bullhorn"></i> 
                              <span>Quadro de Avisos</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Finanças -->
              <li class="has-submenu" data-tab="finances">
                  <div class="menu-item">
                      <i class="fas fa-money-bill-wave"></i> 
                      <span>Finanças</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="financial-management">
                          <a href="finances.php">
                              <i class="fas fa-chart-line"></i> 
                              <span>Gestão Financeira</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
            <!-- Configurações -->
            <li data-tab="settings">
                  <a href="settings.html">
                      <i class="fas fa-cog"></i> 
                      <span>Configurações</span>
                  </a>
              </li>
          </ul>
          <!-- Removed the logout div from here -->
      </nav>
      
      <main class="content">
          <header>
              <div class="search-bar">
                  <i class="fas fa-search"></i>
                  <input type="text" placeholder="Pesquisar...">
              </div>
              <div class="user-info">
                  <div class="user user-dropdown">
                        <img src="login\images\semft-removebg-preview.png" alt="" class="userOptions__avatar img-circle" width="42" height="42">
                        <span><?php echo $_SESSION['fname']; ?></span>

                        <div class="dropdown-menu">
                        <a href="/dashboardpitruca_copia/login/logout.php" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>

                        </div>
                  </div>
              </div>
          </header>

            <div class="tab-content">
                <!-- Gestão de Funcionários - Cadastrar Professores/Coordenadores -->
                <div class="tab-pane active" id="register-guardians">
                    <div class="section-header">
                        <h2>Cadastrar Encarregado</h2>
                        <button class="add-btn" id="add-guardian-btn">
                            <i class="fas fa-plus"></i> Adicionar Encarregado
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Educando</th>
                                    <th>Contato</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="guardian-table-body">
                                <!-- guardian data will be populated here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination">
                        <button class="pagination-btn" disabled><i class="fas fa-chevron-left"></i></button>
                        <button class="pagination-btn active">1</button>
                        <button class="pagination-btn">2</button>
                        <button class="pagination-btn">3</button>
                        <button class="pagination-btn"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para adicionar/editar professores - Optimized -->
<div class="modal" id="guardian-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="guardian-modal-title">Adicionar Novo Encarregado</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="guardian-form">
                <!-- Informações Pessoais -->
                <fieldset>
                    <legend>Informações Pessoais</legend>
                    <div class="form-group">
                        <label for="guardian-name">Nome Completo <span class="required">*</span></label>
                        <input type="text" id="guardian-name" placeholder="Nome completo do aluno" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="guardian-gender">Gênero <span class="required">*</span></label>
                            <select id="guardian-gender" required>
                                <option value="">Selecionar Gênero</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="guardian-dob">Data de Nascimento <span class="required">*</span></label>
                            <input type="date" id="guardian-dob" required>
                        </div>
                    </div>
                    
                    <!-- Bilhete de Identidade (BI) -->
                    <div class="form-group">
                        <label for="bi-number">Número do Bilhete de Identidade (BI) <span class="required">*</span></label>
                        <input type="text" id="bi-number" placeholder="Ex: 0000000LA000" required>
                        <small class="form-hint">Formato: 7 números + 2 letras + 3 números (Ex: 0000000LA000)</small>
                    </div>
                    <div class="form-group">
                        <label>Cópia do BI (Frente e Verso) <span class="required">*</span></label>
                        <div class="file-upload-container">
                            <div class="file-upload">
                                <label for="bi-front">
                                    <div class="upload-area">
                                        <i class="fas fa-upload"></i>
                                        <span>Frente do BI</span>
                                        <small>Clique para selecionar</small>
                                    </div>
                                </label>
                                <input type="file" id="bi-front" accept="image/*" required>
                                <div class="file-preview" id="bi-front-preview"></div>
                            </div>
                            <div class="file-upload">
                                <label for="bi-back">
                                    <div class="upload-area">
                                        <i class="fas fa-upload"></i>
                                        <span>Verso do BI</span>
                                        <small>Clique para selecionar</small>
                                    </div>
                                </label>
                                <input type="file" id="bi-back" accept="image/*" required>
                                <div class="file-preview" id="bi-back-preview"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="guardian-address">Endereço <span class="required">*</span></label>
                        <textarea id="guardian-address" rows="2" placeholder="Endereço completo do aluno" required></textarea>
                    </div>
                </fieldset>
  
                <!-- Informações Acadêmicas -->
                <fieldset>
                    <legend>Informações Acadêmicas</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="guardian-class">Turma <span class="required">*</span></label>
                            <select id="guardian-class" required>
                                <option value="">Selecionar Turma</option>
                                <option value="Turma 10ª A Informática">Turma 10ª A Informática</option>
                                <option value="Turma 10ª B Informática">Turma 10ª B Informática</option>
                                <option value="Turma 11ª Informática">Turma 11ª Informática</option>
                                <option value="Turma 12ª Informática">Turma 12ª Informática</option>
                                <option value="Turma 13ª Informática">Turma 13ª Informática</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="guardian-class">Disciplinas <span class="required">*</span></label>
                            <select id="guardian-class" required>
                                <option value="">Selecionar Disciplinas</option>
                                <option value="LP">Língua Portuguesa</option>
                                <option value="Mat">Matemática</option>
                                <option value="Fis">Física</option>
                                <option value="TLP">Técnina de Linguagem de Programação</option>
                                <option value="TIC">Tecnologia de Informação e Comunicação</option>
                            </select>
                        </div>
                    </div>
                </fieldset>
  
                <!-- Informações de Contato -->
                <fieldset>
                    <legend>Informações de Contato</legend>
                    <div class="form-group">
                        <label for="guardian-contact">Número de Contato <span class="required">*</span></label>
                        <div class="phone-input-container">
                            <select id="country-code" class="country-code">
                                <option value="+244">+244 (Angola)</option>
                                <option value="+351">+351 (Portugal)</option>
                                <option value="+55">+55 (Brasil)</option>
                                <option value="+1">+1 (EUA/Canadá)</option>
                                <option value="+34">+34 (Espanha)</option>
                                <option value="+258">+258 (Moçambique)</option>
                                <option value="+240">+240 (Guiné Equatorial)</option>
                                <option value="+239">+239 (São Tomé e Príncipe)</option>
                                <option value="+238">+238 (Cabo Verde)</option>
                                <option value="+245">+245 (Guiné-Bissau)</option>
                                <option value="+27">+27 (África do Sul)</option>
                                <option value="+33">+33 (França)</option>
                                <option value="+44">+44 (Reino Unido)</option>
                                <option value="+49">+49 (Alemanha)</option>
                                <option value="+86">+86 (China)</option>
                            </select>
                            <input type="tel" id="guardian-contact" placeholder="XXX XXX XXX" required>
                        </div>
                        <small class="form-hint">Formato: XXX XXX XXX (sem espaços ou traços)</small>
                    </div>
                    <div class="form-group">
                        <label for="guardian-email">Email <span class="required">*</span></label>
                        <input type="email" id="guardian-email" placeholder="exemplo@email.com" required>
                    </div>
                </fieldset>
                <!-- Credenciais de Acesso -->
                <fieldset>
                    <legend>Credenciais de Acesso</legend>
                    <div class="form-group password-field">
                        <label for="password">Palavra-Passe <span class="required">*</span></label>
                        <div class="password-input-container">
                            <input type="password" id="password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                            <button type="button" class="password-toggle" tabindex="-1">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-hint">A senha deve ter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e símbolos</small>
                    </div>
                </fieldset>
  
                <div class="form-actions">
                    <button type="button" class="cancel-btn" id="cancel-guardian-btn">Cancelar</button>
                    <button type="submit" class="save-btn">Salvar Professor</button>
                </div>
            </form>
        </div>
    </div>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Get the user dropdown element
      const userDropdown = document.querySelector('.user-dropdown');
      const dropdownMenu = document.querySelector('.dropdown-menu');
      
      // Toggle dropdown when username is clicked
      userDropdown.addEventListener('click', function() {
        dropdownMenu.classList.toggle('show');
      });
      
      // Close dropdown when clicking outside
      document.addEventListener('click', function(event) {
        if (!userDropdown.contains(event.target)) {
          dropdownMenu.classList.remove('show');
        }
      });
      
      // No special automatic display - dropdown only shows when clicked
    });
  </script>
  
    
    <script src="js/script.js"></script>
</body>
</html>
<?php }else{
    header("Location: ../login.php");
    exit;
} ?>

