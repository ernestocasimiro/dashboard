<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

require_once 'dbconnection.php';

// Configuração ÚNICA da pasta de uploads (caminho absoluto)
$upload_dir = __DIR__ . '/uploads/teachers/bi/';

// Criar pastas automaticamente se não existirem
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true) or die("Erro: Não foi possível criar a pasta de uploads!");
}

// Verificar se a pasta é gravável
if (!is_writable($upload_dir)) {
    die("Erro: A pasta de uploads não tem permissão de escrita!");
}

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_teacher'])) {
    try {
        // Validar e sanitizar os dados
        $full_name = filter_input(INPUT_POST, 'teacher-name', FILTER_SANITIZE_STRING);
        $gender = filter_input(INPUT_POST, 'teacher-gender', FILTER_SANITIZE_STRING);
        $date_of_birth = $_POST['teacher-dob'];
        $bi_number = filter_input(INPUT_POST, 'bi-number', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'teacher-address', FILTER_SANITIZE_STRING);
        $country_code = filter_input(INPUT_POST, 'country-code', FILTER_SANITIZE_STRING);
        $phone_number = filter_input(INPUT_POST, 'teacher-contact', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'teacher-email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $subjects = $_POST['teacher-subjects'] ?? [];
        $is_coordinator = isset($_POST['is_coordinator']) ? 1 : 0;

        // Validações básicas
        if (empty($full_name) || empty($gender) || empty($date_of_birth) || empty($bi_number) || 
            empty($address) || empty($phone_number) || empty($email) || empty($password)) {
            throw new Exception("Todos os campos obrigatórios devem ser preenchidos.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("O email fornecido é inválido.");
        }

        if (strlen($password) < 8) {
            throw new Exception("A senha deve ter pelo menos 8 caracteres.");
        }

        // Hash da senha
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Processar upload das imagens do BI
        $bi_front_image = null;
        $bi_back_image = null;

        // Processar frente do BI
        if (isset($_FILES['bi-front']) && $_FILES['bi-front']['error'] === UPLOAD_ERR_OK) {
            $file_ext = pathinfo($_FILES['bi-front']['name'], PATHINFO_EXTENSION);
            $filename = 'bi_front_' . uniqid() . '.' . $file_ext;
            $filepath = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['bi-front']['tmp_name'], $filepath)) {
                $bi_front_image = 'uploads/teachers/bi/' . $filename; // Caminho relativo para BD
            } else {
                throw new Exception("Falha ao salvar a frente do BI.");
            }
        }

        // Processar verso do BI
        if (isset($_FILES['bi-back']) && $_FILES['bi-back']['error'] === UPLOAD_ERR_OK) {
            $file_ext = pathinfo($_FILES['bi-back']['name'], PATHINFO_EXTENSION);
            $filename = 'bi_back_' . uniqid() . '.' . $file_ext;
            $filepath = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['bi-back']['tmp_name'], $filepath)) {
                $bi_back_image = 'uploads/teachers/bi/' . $filename; // Caminho relativo para BD
            } else {
                // Remove o arquivo da frente se o verso falhar
                if ($bi_front_image && file_exists($upload_dir . basename($bi_front_image))) {
                    unlink($upload_dir . basename($bi_front_image));
                }
                throw new Exception("Falha ao salvar o verso do BI.");
            }
        }

        // Iniciar transação
        $pdo->beginTransaction();

        // Inserir o professor na tabela teachers
        $stmt = $pdo->prepare("INSERT INTO teachers 
            (full_name, gender, date_of_birth, bi_number, bi_front_image, bi_back_image, 
             address, country_code, phone_number, email, password_hash, is_coordinator) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $full_name, $gender, $date_of_birth, $bi_number, $bi_front_image, $bi_back_image,
            $address, $country_code, $phone_number, $email, $password_hash, $is_coordinator
        ]);

        $teacher_id = $pdo->lastInsertId();

        // Inserir disciplinas do professor
        if (!empty($subjects)) {
            $stmt = $pdo->prepare("INSERT INTO teacher_subjects (teacher_id, subject_id, academic_year) 
                                  VALUES (?, ?, ?)");
            
            $academic_year = date('Y') . '-' . (date('Y') + 1); // Ex: 2023-2024
            
            foreach ($subjects as $subject_id) {
                $stmt->execute([$teacher_id, $subject_id, $academic_year]);
            }
        }

        // Confirmar transação
        $pdo->commit();

        // Redirecionar com mensagem de sucesso
        $_SESSION['success_message'] = "Professor cadastrado com sucesso! ID: " . $teacher_id;
        header("Location: teacher.php");
        exit;

    } catch (Exception $e) {
        // Em caso de erro, desfazer a transação
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }

        // Apagar arquivos enviados em caso de erro
        if (isset($bi_front_image) && file_exists($upload_dir . basename($bi_front_image))) {
            unlink($upload_dir . basename($bi_front_image));
        }
        if (isset($bi_back_image) && file_exists($upload_dir . basename($bi_back_image))) {
            unlink($upload_dir . basename($bi_back_image));
        }

        $_SESSION['error_message'] = "Erro ao cadastrar professor: " . $e->getMessage();
        header("Location: teacher.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professores - Sistema de Gestão Escolar</title>
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
                  <ul class="submenu">
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
              <li class="has-submenu active" data-tab="staff-management">
                  <div class="menu-item">
                      <i class="fas fa-chalkboard-teacher"></i> 
                      <span>Gestão de Funcionários</span>
                      <i class="fas fa-chevron-down arrow"></i>
                  </div>
                  <ul class="submenu show">
                      <li class="active" data-tab="register-teachers">
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
          <div class="logout">
              <i class="fas fa-sign-out-alt"></i> 
              <span>Sair</span>
          </div>
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

        <!-- Exibir mensagens de sucesso/erro -->
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
            
            <div class="tab-content">
                <!-- Gestão de Funcionários - Cadastrar Professores/Coordenadores -->
                <div class="tab-pane active" id="register-teacher">
                    <div class="section-header">
                        <h2>Cadastrar Professor</h2>
                        <button class="add-btn" id="add-teacher-btn">
                            <i class="fas fa-plus"></i> Adicionar Professor
                        </button>
                    </div>
                    
                    <div class="table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Disciplinas</th>
                <th>Contato</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("
                SELECT t.id, t.full_name, t.phone_number, t.email, t.status,
                       GROUP_CONCAT(s.subject_name SEPARATOR ', ') AS subjects
                FROM teachers t
                LEFT JOIN teacher_subjects ts ON t.id = ts.teacher_id
                LEFT JOIN subjects s ON ts.subject_id = s.id
                GROUP BY t.id
                ORDER BY t.full_name
            ");
            
            while ($teacher = $stmt->fetch()):
            ?>
            <tr>
                <td><?= $teacher['id'] ?></td>
                <td><?= htmlspecialchars($teacher['full_name']) ?></td>
                <td><?= $teacher['subjects'] ? htmlspecialchars($teacher['subjects']) : 'Nenhuma' ?></td>
                <td>
                    <?= htmlspecialchars($teacher['phone_number']) ?><br>
                    <?= htmlspecialchars($teacher['email']) ?>
                </td>
                <td>
                    <span class="status-badge <?= $teacher['status'] ?>">
                        <?= ucfirst($teacher['status']) ?>
                    </span>
                </td>
                <td class="actions">
                    <button class="edit-btn" data-teacher-id="<?= $teacher['id'] ?>">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="delete-btn" data-teacher-id="<?= $teacher['id'] ?>">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            <?php endwhile; ?>
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

    <!-- Modal para adicionar/editar professores -->
<div class="modal" id="teacher-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="teacher-modal-title">Adicionar Novo Professor</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body">
        <form id="teacher-form" method="POST" enctype="multipart/form-data">
    <!-- Informações Pessoais -->
    <fieldset>
        <legend>Informações Pessoais</legend>
        <div class="form-group">
            <label for="teacher-name">Nome Completo <span class="required">*</span></label>
            <input type="text" id="teacher-name" name="teacher-name" placeholder="Nome completo do professor" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="teacher-gender">Gênero <span class="required">*</span></label>
                <select id="teacher-gender" name="teacher-gender" required>
                    <option value="">Selecionar Gênero</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Feminino">Feminino</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>
            <div class="form-group">
                <label for="teacher-dob">Data de Nascimento <span class="required">*</span></label>
                <input type="date" id="teacher-dob" name="teacher-dob" required>
            </div>
        </div>
        
        <!-- Bilhete de Identidade (BI) -->
        <div class="form-group">
            <label for="bi-number">Número do Bilhete de Identidade (BI) <span class="required">*</span></label>
            <input type="text" id="bi-number" name="bi-number" placeholder="Ex: 0000000LA000" required>
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
                    <input type="file" id="bi-front" name="bi-front" accept="image/*" required>
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
                    <input type="file" id="bi-back" name="bi-back" accept="image/*" required>
                    <div class="file-preview" id="bi-back-preview"></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="teacher-address">Endereço <span class="required">*</span></label>
            <textarea id="teacher-address" name="teacher-address" rows="2" placeholder="Endereço completo" required></textarea>
        </div>
    </fieldset>

    <!-- Informações Acadêmicas -->
    <fieldset>
        <legend>Informações Acadêmicas</legend>
        <div class="form-group">
            <label for="teacher-subjects">Disciplinas <span class="required">*</span></label>
            <select id="teacher-subjects" name="teacher-subjects[]" multiple required>
                <?php
                // Buscar disciplinas do banco de dados
                $stmt = $pdo->query("SELECT id, subject_code, subject_name FROM subjects WHERE is_active = 1");
                $subjects = $stmt->fetchAll();
                
                foreach ($subjects as $subject) {
                    echo '<option value="' . $subject['id'] . '">' . 
                         htmlspecialchars($subject['subject_code'] . ' - ' . $subject['subject_name']) . 
                         '</option>';
                }
                ?>
            </select>
            <small class="form-hint">Segure Ctrl (Windows) ou Command (Mac) para selecionar múltiplas disciplinas</small>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" id="is_coordinator" name="is_coordinator" value="1">
                Este professor é um coordenador?
            </label>
        </div>
    </fieldset>

    <!-- Informações de Contato -->
    <fieldset>
        <legend>Informações de Contato</legend>
        <div class="form-group">
            <label for="teacher-contact">Número de Contato <span class="required">*</span></label>
            <div class="phone-input-container">
                <select id="country-code" name="country-code" class="country-code">
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
                <input type="tel" id="teacher-contact" name="teacher-contact" placeholder="XXX XXX XXX" required>
            </div>
            <small class="form-hint">Formato: XXX XXX XXX (sem espaços ou traços)</small>
        </div>
        <div class="form-group">
            <label for="teacher-email">Email <span class="required">*</span></label>
            <input type="email" id="teacher-email" name="teacher-email" placeholder="exemplo@email.com" required>
        </div>
    </fieldset>
    
    <!-- Credenciais de Acesso -->
    <fieldset>
        <legend>Credenciais de Acesso</legend>
        <div class="form-group password-field">
            <label for="password">Palavra-Passe <span class="required">*</span></label>
            <div class="password-input-container">
                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres" minlength="8" required>
                <button type="button" class="password-toggle" tabindex="-1">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <small class="form-hint">A senha deve ter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas, números e símbolos</small>
        </div>
    </fieldset>

    <div class="form-actions">
        <button type="button" class="cancel-btn" id="cancel-teacher-btn">Cancelar</button>
        <button type="submit" class="save-btn" name="save_teacher">Salvar Professor</button>
    </div>
</form>
        </div>
    </div>
</div>

   
<script src="js/script.js"></script>

<script>
      document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const teacherId = this.getAttribute('data-teacher-id');
            
            fetch(`get_teacher.php?id=${teacherId}`)
                .then(response => response.json())
                .then(data => {
                    // Preencher o modal com os dados do professor
                    document.getElementById('teacher-modal-title').textContent = 'Editar Professor';
                    document.getElementById('teacher-name').value = data.full_name;
                    // Preencher todos os outros campos...
                    
                    // Mostrar o modal
                    document.getElementById('teacher-modal').style.display = 'block';
                });
        });
    });

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

    
    

    document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (confirm('Tem certeza que deseja excluir este professor?')) {
            const teacherId = this.getAttribute('data-teacher-id');
            
            fetch(`delete_teacher.php?id=${teacherId}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao excluir: ' + data.error);
                    }
                });
        }
    });
});

// Visualização das imagens do BI antes do upload
document.getElementById('bi-front').addEventListener('change', function(e) {
    const preview = document.getElementById('bi-front-preview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 100px; max-height: 100px;">';
        }
        reader.readAsDataURL(this.files[0]);
    }
});

document.getElementById('bi-back').addEventListener('change', function(e) {
    const preview = document.getElementById('bi-back-preview');
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 100px; max-height: 100px;">';
        }
        reader.readAsDataURL(this.files[0]);
    }
});

// Alternar visibilidade da senha
document.querySelector('.password-toggle').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

// Controle do Modal
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('teacher-modal');
    const addTeacherBtn = document.getElementById('add-teacher-btn');
    const closeModal = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-teacher-btn');

    // Abrir modal ao clicar em Adicionar Professor
    if (addTeacherBtn) {
        addTeacherBtn.addEventListener('click', function() {
            document.getElementById('teacher-modal-title').textContent = 'Adicionar Novo Professor';
            document.getElementById('teacher-form').reset();
            modal.style.display = 'block';
        });
    }

    // Fechar modal
    if (closeModal) {
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    // Fechar ao clicar fora
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Visualização das imagens do BI
    const setupFilePreview = (inputId, previewId) => {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        
        if (input && preview) {
            input.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = '<img src="' + e.target.result + '" style="max-width: 100px; max-height: 100px;">';
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    };
    
    setupFilePreview('bi-front', 'bi-front-preview');
    setupFilePreview('bi-back', 'bi-back-preview');

    // Alternar visibilidade da senha
    const passwordToggle = document.querySelector('.password-toggle');
    if (passwordToggle) {
        passwordToggle.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    }
});

</script>
  

</body>
</html>

