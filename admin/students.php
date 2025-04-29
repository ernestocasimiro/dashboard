<?php
    session_start();
    
    if (isset($_SESSION['id']) && isset($_SESSION['role'])) {
        include('dbconnection.php');
    
        if (isset($_POST['submit'])) {
            // Sanitização dos dados
            $fname = htmlspecialchars(trim($_POST['fname']));
            $lname = htmlspecialchars(trim($_POST['lname']));
            $genero = $_POST['genero'];
            $dataa = $_POST['dataa'];
            $numbi = $_POST['numbi'];
            $endereco = htmlspecialchars(trim($_POST['endereco']));
            $turma_id = $_POST['turma']; // Agora recebe o ID da turma
            $escola = htmlspecialchars(trim($_POST['escola']));
            $telefone = $_POST['telefone'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $encarregado_id = $_POST['encarregado']; // Agora recebe o ID do encarregado
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
            // Validação do BI
            if (!preg_match('/^\d{7}[A-Za-z]{2}\d{3}$/', $numbi)) {
                $_SESSION['error'] = "Formato do BI inválido. Use o formato: 0000000LA000";
                header("Location: students.php");
                exit;
            }
    
            // Validação do telefone
            if (!preg_match('/^\d{9}$/', $telefone)) {
                $_SESSION['error'] = "Número de telefone inválido. Use 9 dígitos.";
                header("Location: students.php");
                exit;
            }
    
            // Validação de email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email inválido.";
                header("Location: students.php");
                exit;
            }
    
            // Upload de imagens
            $uploadDir = "uploads/students/";
            $foto_bi1 = uploadFile($_FILES['foto_bi1'], $uploadDir, ['jpg', 'jpeg', 'png']);
            $foto_bi2 = uploadFile($_FILES['foto_bi2'], $uploadDir, ['jpg', 'jpeg', 'png']);
            $fotoperfil = uploadFile($_FILES['fotoperfil'], $uploadDir, ['jpg', 'jpeg', 'png']);
    
            if (!$foto_bi1 || !$foto_bi2 || !$fotoperfil) {
                $_SESSION['error'] = "Erro no upload de imagens. Verifique os arquivos enviados.";
                header("Location: students.php");
                exit;
            }
    
            // Verificar capacidade da turma
            $capacity_check = mysqli_prepare($con, "SELECT capacidade, (SELECT COUNT(*) FROM students WHERE turma_id = ?) as alunos_matriculados FROM turmas WHERE id = ?");
            mysqli_stmt_bind_param($capacity_check, "ii", $turma_id, $turma_id);
            mysqli_stmt_execute($capacity_check);
            mysqli_stmt_bind_result($capacity_check, $capacidade, $alunos_matriculados);
            mysqli_stmt_fetch($capacity_check);
            mysqli_stmt_close($capacity_check);
    
            if ($alunos_matriculados >= $capacidade) {
                $_SESSION['error'] = "Turma lotada. Não é possível adicionar mais alunos.";
                header("Location: students.php");
                exit;
            }
    
            // Inserção no banco com prepared statement
            $query = mysqli_prepare($con, 
                "INSERT INTO students (fname, lname, genero, dataa, numbi, foto_bi1, foto_bi2, endereco, fotoperfil, turma_id, escola, telefone, email, encarregado_id, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
            mysqli_stmt_bind_param($query, "sssssssssisssis", 
                $fname, $lname, $genero, $dataa, $numbi, $foto_bi1, $foto_bi2, $endereco, 
                $fotoperfil, $turma_id, $escola, $telefone, $email, $encarregado_id, $password);
    
            if (mysqli_stmt_execute($query)) {
                $_SESSION['success'] = "Aluno adicionado com sucesso!";
                header("Location: students.php");
                exit;
            } else {
                $_SESSION['error'] = "Erro ao adicionar aluno: " . mysqli_error($con);
                header("Location: students.php");
                exit;
            }
        }
    
        // Função para upload de arquivos
        function uploadFile($file, $uploadDir, $allowedExtensions) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return false;
            }
    
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowedExtensions)) {
                return false;
            }
    
            $filename = uniqid() . '.' . $extension;
            $destination = $uploadDir . $filename;
    
            if (!move_uploaded_file($file['tmp_name'], $destination)) {
                return false;
            }
    
            return $filename;
        }
    ?>


<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estudantes - Sistema Pitruca Camama</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
    /* Estilos para mensagens de feedback */
.alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.alert-error {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

/* Estilos para preview de imagens */
.file-preview {
    margin-top: 10px;
    max-width: 200px;
    max-height: 200px;
    overflow: hidden;
}

.file-preview img {
    max-width: 100%;
    max-height: 100%;
    border-radius: 4px;
}

/* Melhorias nos selects */
.select2-container {
    width: 100% !important;
}
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
              <li class="has-submenu active" data-tab="student-management">
                  <div class="menu-item">
                      <i class="fas fa-user-graduate"></i> 
                      <span>Gestão De Alunos</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu show">
                      <li class="active" data-tab="register-students">
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
                              <span>Professores</span>
                          </a>
                      </li>
                  </ul>
              </li>
              
              <!-- Utilizadores -->
              <li class="has-submenu" data-tab="users">
                  <div class="menu-item">
                      <i class="fas fa-users"></i> 
                      <span>Utilizadores</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu">
                      <li data-tab="guardians">
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
                  <a href="settings.php">
                      <i class="fas fa-cog"></i> 
                      <span>Configurações</span>
                  </a>
              </li>
          </ul>
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
          </header>
          
          <div class="tab-content">
              <!-- Gestão De Alunos - Cadastrar Estudantes -->
              <div class="tab-pane active" id="register-students">
                  <div class="section-header">
                      <h2>Estudantes</h2>
                      <button class="add-btn" id="add-student-btn">
                          <i class="fas fa-plus"></i> Adicionar Aluno
                      </button>
                  </div>
                  
                  <div class="filter-controls">
                      <div class="search-filter">
                          <input type="text" id="student-search" placeholder="Pesquisar alunos...">
                      </div>
                      <div class="dropdown-filter">
                          <select id="class-filter">
                              <option value="">Todas as Turmas</option>
                              <option value="Turma 10ª A Informática">Turma 10ª A Informática</option>
                              <option value="Turma 10ª B Informática">Turma 10ª B Informática</option>
                              <option value="Turma 11ª Informática">Turma 11ª Infomática</option>
                              <option value="Turma 12ª Informática">Turma 12ª Informática</option>
                              <option value="Turma 13ª Informática">Turma 13ª Informática</option>
                          </select>
                      </div>
                  </div>
                  
                  <div class="table-container">
                      <table class="data-table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Nome</th>
                                  <th>Turma</th>
                                  <th>Gênero</th>
                                  <th>Contato</th>
                                  <th>Presença</th>
                                  <th>Ações</th>
                              </tr>
                          </thead>
                          <tbody id="student-table-body">
                                        <!-- Alunos -->
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
  
  <div class="modal" id="student-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="student-modal-title">Adicionar Novo Aluno</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="student-form" enctype="multipart/form-data" method="POST" action="students.php">
                <!-- Informações Pessoais -->
                <fieldset>
                    <legend>Informações Pessoais</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="student-fname">Primeiro Nome <span class="required">*</span></label>
                            <input type="text" id="student-fname" placeholder="Primeiro Nome" name="fname" required>
                        </div>
                        <div class="form-group">
                            <label for="student-lname">Sobrenome <span class="required">*</span></label>
                            <input type="text" id="student-lname" placeholder="Sobrenome" name="lname" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="student-gender">Gênero <span class="required">*</span></label>
                            <select id="student-gender" name="genero" required>
                                <option value="">Selecionar Gênero</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Feminino">Feminino</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="student-dob">Data de Nascimento <span class="required">*</span></label>
                            <input type="date" id="student-dob" name="dataa" required>
                        </div>
                    </div>
                    
                    <!-- Bilhete de Identidade -->
                    <div class="form-group">
                        <label for="bi-number">Número do BI <span class="required">*</span></label>
                        <input type="text" id="bi-number" placeholder="0000000LA000" name="numbi" 
                               pattern="\d{7}[A-Za-z]{2}\d{3}" title="7 números + 2 letras + 3 números" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Cópia do BI <span class="required">*</span></label>
                        <div class="file-upload-container">
                            <div class="file-upload">
                                <input type="file" id="bi-front" name="foto_bi1" accept="image/*" required>
                                <label for="bi-front" class="file-upload-label">
                                    <div class="upload-area">
                                        <i class="fas fa-upload"></i>
                                        <span>Frente do BI</span>
                                    </div>
                                </label>
                                <div class="file-preview" id="bi-front-preview"></div>
                            </div>
                            <div class="file-upload">
                                <input type="file" id="bi-back" name="foto_bi2" accept="image/*" required>
                                <label for="bi-back" class="file-upload-label">
                                    <div class="upload-area">
                                        <i class="fas fa-upload"></i>
                                        <span>Verso do BI</span>
                                    </div>
                                </label>
                                <div class="file-preview" id="bi-back-preview"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="student-address">Endereço <span class="required">*</span></label>
                        <textarea id="student-address" rows="2" name="endereco" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="student-photo">Foto de Perfil <span class="required">*</span></label>
                        <div class="file-upload">
                            <input type="file" id="student-photo" name="fotoperfil" accept="image/*" required>
                            <label for="student-photo" class="file-upload-label">
                                <div class="upload-area">
                                    <i class="fas fa-user-circle"></i>
                                    <span>Selecionar Foto</span>
                                </div>
                            </label>
                            <div class="file-preview" id="student-photo-preview"></div>
                        </div>
                    </div>
                </fieldset>

                <!-- Informações Acadêmicas -->
                <fieldset>
                    <legend>Informações Acadêmicas</legend>
                    <div class="form-group">
                        <label for="student-class">Turma <span class="required">*</span></label>
                        <div class="select-with-button">
                            <select id="student-class" name="turma" required>
                                <option value="">Carregando turmas...</option>
                            </select>
                        </div>
                        <div id="class-capacity-info" class="capacity-info"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="previous-school">Escola Anterior</label>
                        <input type="text" id="previous-school" name="escola">
                    </div>
                </fieldset>

                <!-- Informações de Contato -->
                <fieldset>
                    <legend>Informações de Contato</legend>
                    <div class="form-group">
                        <label for="student-phone">Telefone <span class="required">*</span></label>
                        <input type="tel" id="student-phone" name="telefone" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="student-email">Email <span class="required">*</span></label>
                        <input type="email" id="student-email" name="email" required>
                    </div>
                </fieldset>

                <!-- Encarregado de Educação -->
                <fieldset>
                    <legend>Encarregado de Educação <span class="required">*</span></legend>
                    <div class="form-group">
                        <div class="select-with-button">
                            <select id="parents" name="encarregado" required>
                                <option value="">Carregando encarregados...</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <!-- Credenciais de Acesso -->
                <fieldset>
                    <legend>Credenciais de Acesso</legend>
                    <div class="form-group">
                        <label for="password">Senha <span class="required">*</span></label>
                        <div class="password-input-container">
                            <input type="password" id="password" name="password" minlength="8" required>
                            <button type="button" class="password-toggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-hint">Mínimo 8 caracteres (letras, números e símbolos)</small>
                    </div>
                </fieldset>

                <div class="form-actions">
                    <button type="button" class="cancel-btn">Cancelar</button>
                    <button type="submit" class="save-btn">Salvar Aluno</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Novo Encarregado -->
<div class="modal" id="guardian-modal" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3>Cadastrar Novo Encarregado</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="guardian-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="guardian-name">Nome Completo <span class="required">*</span></label>
                        <input type="text" id="guardian-name" required>
                    </div>
                    <div class="form-group">
                        <label for="guardian-relation">Parentesco <span class="required">*</span></label>
                        <select id="guardian-relation" required>
                            <option value="">Selecione</option>
                            <option value="Pai">Pai</option>
                            <option value="Mãe">Mãe</option>
                            <option value="Tio(a)">Tio(a)</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="guardian-phone">Telefone <span class="required">*</span></label>
                    <input type="tel" id="guardian-phone" required>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="cancel-btn">Cancelar</button>
                    <button type="submit" class="save-btn">Salvar Encarregado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Nova Turma -->
<div class="modal" id="class-modal" style="display: none;">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3>Cadastrar Nova Turma</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
            <form id="class-form">
                <div class="form-group">
                    <label for="new-class-name">Nome da Turma <span class="required">*</span></label>
                    <input type="text" id="new-class-name" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="new-class-grade">Ano/Classe <span class="required">*</span></label>
                        <select id="new-class-grade" required>
                            <option value="">Selecione</option>
                            <option value="10">1ª Classe</option>
                            <option value="10">2ª Classe</option>
                            <option value="10">3ª Classe</option>
                            <option value="10">4ª Classe</option>
                            <option value="10">5ª Classe</option>
                            <option value="10">6ª Classe</option>
                            <option value="10">7ª Classe</option>
                            <option value="10">8ª Classe</option>
                            <option value="10">9ª Classe</option>
                            <option value="10">10ª Classe</option>
                            <option value="11">11ª Classe</option>
                            <option value="12">12ª Classe</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="new-class-capacity">Capacidade (Max. 25) <span class="required">*</span></label>
                        <input type="number" id="new-class-capacity" min="1" max="25" value="25" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="cancel-btn">Cancelar</button>
                    <button type="submit" class="save-btn">Salvar Turma</button>
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

    function loadGuardiansForSelect() {
    fetch('api/guardians.php?action=getAll')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('parents'); // ID correto do form
            select.innerHTML = '<option value="">Selecionar Encarregado</option>';
            
            data.forEach(guardian => {
                const option = document.createElement('option');
                option.value = guardian.id;
                option.textContent = guardian.name + (guardian.contact ? ` (${guardian.contact})` : '');
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Erro ao carregar encarregados:', error));
}


// Botão para adicionar novo encarregado
document.getElementById('add-new-guardian-btn').addEventListener('click', function() {
    // Abre o modal de encarregado
    document.getElementById('add-guardian-btn').click();
    
    // Quando o modal de encarregado é fechado, recarrega a lista
    document.getElementById('guardian-modal').addEventListener('hidden', function() {
        loadGuardiansForSelect();
    });
});

// Carregar encarregados quando o formulário de aluno é aberto
loadGuardiansForSelect();

document.addEventListener('DOMContentLoaded', function() {
    // Controle dos modais
    const studentModal = document.getElementById('student-modal');
    const guardianModal = document.getElementById('guardian-modal');
    const classModal = document.getElementById('class-modal');
    
    // Abrir modal de aluno
    document.getElementById('add-student-btn').addEventListener('click', function() {
        studentModal.style.display = 'block';
        loadClasses();
        loadGuardians();
    });
    
    // Abrir modal de encarregado
    document.getElementById('add-guardian-btn').addEventListener('click', function() {
        guardianModal.style.display = 'block';
    });
    
    // Abrir modal de turma
    document.getElementById('add-class-btn').addEventListener('click', function() {
        classModal.style.display = 'block';
    });
    
    // Fechar todos os modais
    function closeAllModals() {
        studentModal.style.display = 'none';
        guardianModal.style.display = 'none';
        classModal.style.display = 'none';
    }
    
    // Carregar turmas
    async function loadClasses() {
        try {
            const response = await fetch('api/get_classes.php');
            const classes = await response.json();
            
            const select = document.getElementById('student-class');
            select.innerHTML = '<option value="">Selecione uma turma</option>';
            
            classes.forEach(turma => {
                const option = document.createElement('option');
                option.value = turma.id;
                option.textContent = turma.nome;
                option.dataset.capacity = turma.capacidade;
                option.dataset.current = turma.alunos_matriculados;
                select.appendChild(option);
            });
            
            // Atualizar info de capacidade
            updateClassCapacityInfo();
        } catch (error) {
            console.error('Erro ao carregar turmas:', error);
        }
    }
    
    // Atualizar informação de capacidade
    function updateClassCapacityInfo() {
        const select = document.getElementById('student-class');
        const infoDiv = document.getElementById('class-capacity-info');
        const saveBtn = document.querySelector('#student-form .save-btn');
        
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value) {
            const capacity = parseInt(selectedOption.dataset.capacity);
            const current = parseInt(selectedOption.dataset.current);
            
            if (current >= capacity) {
                infoDiv.innerHTML = `<span class="error">Turma lotada (${current}/${capacity})</span>`;
                saveBtn.disabled = true;
            } else {
                infoDiv.innerHTML = `Vagas disponíveis: ${capacity - current}/${capacity}`;
                saveBtn.disabled = false;
            }
        } else {
            infoDiv.innerHTML = '';
            saveBtn.disabled = false;
        }
    }
    
    // Observar mudanças na seleção de turma
    document.getElementById('student-class').addEventListener('change', updateClassCapacityInfo);
    
    // Cadastrar novo encarregado
    document.getElementById('guardian-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Implementar lógica de cadastro...
    });
    
    // Cadastrar nova turma
    document.getElementById('class-form').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Implementar lógica de cadastro...
    });
    
    // Fechar modais
    document.querySelectorAll('.close-modal, .cancel-btn').forEach(btn => {
        btn.addEventListener('click', closeAllModals);
    });
    
    window.addEventListener('click', function(e) {
        if (e.target === studentModal || e.target === guardianModal || e.target === classModal) {
            closeAllModals();
        }
    });
    
    // Preview de imagens
    function setupImagePreviews() {
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const previewId = this.id + '-preview';
                const preview = document.getElementById(previewId);
                
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        preview.innerHTML = `<img src="${e.target.result}">`;
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    }
    
    setupImagePreviews();
});
</script>

<style>
/* Estilos para os modais e formulários */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.close-modal {
    font-size: 24px;
    cursor: pointer;
}

.form-group {
    margin-bottom: 15px;
}

.form-row {
    display: flex;
    gap: 15px;
}

.form-row .form-group {
    flex: 1;
}

.select-with-button {
    display: flex;
    gap: 8px;
}

.select-with-button select {
    flex: 1;
}

.small-btn {
    padding: 8px 12px;
    background: #f0f0f0;
    border: 1px solid #ddd;
    cursor: pointer;
}

.capacity-info {
    margin-top: 5px;
    font-size: 0.9em;
}

.capacity-info .error {
    color: #dc3545;
    font-weight: bold;
}

.file-upload-container {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.file-upload {
    flex: 1;
}

.file-upload-label {
    display: block;
    cursor: pointer;
}

.upload-area {
    border: 2px dashed #ddd;
    padding: 15px;
    text-align: center;
    border-radius: 5px;
}

.file-preview {
    margin-top: 10px;
}

.file-preview img {
    max-width: 100%;
    max-height: 150px;
    border-radius: 5px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.cancel-btn, .save-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.cancel-btn {
    background-color: #f0f0f0;
}

.save-btn {
    background-color: #007bff;
    color: white;
}

.password-input-container {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
}
</style>
  <script src="js/script.js"></script>
</body>
</html>

<?php }else{
    header("Location: ../login.php");
    exit;
} ?>

