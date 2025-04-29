class GuardiansManager {
  constructor() {
      this.elements = {
          addGuardianBtn: document.getElementById('add-guardian-btn'),
          guardianModal: document.getElementById('guardian-modal'),
          closeModal: document.querySelector('.close-modal'),
          cancelBtn: document.getElementById('cancel-guardian-btn'),
          guardianForm: document.getElementById('guardian-form'),
          guardianTableBody: document.getElementById('guardian-table-body')
      };

      this.state = {
          currentGuardianId: null,
          isSubmitting: false
      };

      this.init();
  }

  init() {
      this.setupEventListeners();
      this.loadGuardians();
  }

  setupEventListeners() {
      this.elements.addGuardianBtn?.addEventListener('click', () => this.openAddGuardianModal());
      this.elements.closeModal?.addEventListener('click', () => this.closeGuardianModal());
      this.elements.cancelBtn?.addEventListener('click', () => this.closeGuardianModal());
      this.elements.guardianForm?.addEventListener('submit', (e) => this.handleFormSubmit(e));

      window.addEventListener('click', (event) => {
          if (event.target === this.elements.guardianModal) {
              this.closeGuardianModal();
          }
      });
  }
  async loadGuardians() {
    try {
      const response = await fetch('api/guardians.php?action=get');
      
      // Verifica se a resposta é válida
      if (!response.ok) {
        throw new Error(`Erro HTTP: ${response.status}`);
      }
  
      // Verifica o tipo de conteúdo
      const contentType = response.headers.get('content-type');
      if (!contentType || !contentType.includes('application/json')) {
        throw new Error('Resposta não é JSON válido');
      }
  
      // Lê o texto da resposta para depuração
      const responseText = await response.text();
      console.log('Resposta bruta:', responseText); // Para depuração
  
      // Tenta parsear o JSON
      let result;
      try {
        result = JSON.parse(responseText);
      } catch (parseError) {
        console.error('Erro ao parsear JSON:', parseError);
        throw new Error('Dados recebidos não são JSON válido');
      }
  
      // Verifica a estrutura do JSON
      if (!result || typeof result !== 'object') {
        throw new Error('Estrutura de dados inválida');
      }
  
      // Extrai os dados (compatível com vários formatos)
      const data = Array.isArray(result) ? result : 
                  (result.data || result.guardians || []);
  
      // Renderiza os dados
      this.renderGuardians(data);
  
    } catch (error) {
      console.error('Error loading guardians:', error);
      this.showErrorInTable(error.message);
    }
  }
  
  renderGuardians(data) {
    this.elements.guardianTableBody.innerHTML = '';
  
    if (!Array.isArray(data)) {
      this.showErrorInTable('Dados recebidos em formato inválido');
      return;
    }
  
    if (data.length === 0) {
      this.elements.guardianTableBody.innerHTML = `
        <tr><td colspan="5">Nenhum encarregado cadastrado</td></tr>
      `;
      return;
    }
  
    data.forEach(guardian => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${guardian.id || 'N/A'}</td>
        <td>${guardian.name || 'N/A'}</td>
        <td>${guardian.gender || 'N/A'}</td>
        <td>${guardian.contact || 'N/A'}</td>
        <td class="actions">
          <button class="edit-btn" data-id="${guardian.id}">
            <i class="fas fa-edit"></i>
          </button>
          <button class="delete-btn" data-id="${guardian.id}">
            <i class="fas fa-trash"></i>
          </button>
        </td>
      `;
      this.elements.guardianTableBody.appendChild(row);
    });
  
    this.addButtonEventListeners();
  }

  renderGuardians(guardians) {
      this.elements.guardianTableBody.innerHTML = '';

      if (!guardians || guardians.length === 0) {
          this.elements.guardianTableBody.innerHTML = `
              <tr>
                  <td colspan="5" class="text-center">Nenhum encarregado cadastrado</td>
              </tr>
          `;
          return;
      }

      guardians.forEach(guardian => {
          const row = document.createElement('tr');
          row.innerHTML = `
              <td>${guardian.id}</td>
              <td>${guardian.name}</td>
              <td>${guardian.gender || 'N/A'}</td>
              <td>${guardian.contact}</td>
              <td class="actions">
                  <button class="edit-btn" data-id="${guardian.id}">
                      <i class="fas fa-edit"></i>
                  </button>
                  <button class="delete-btn" data-id="${guardian.id}">
                      <i class="fas fa-trash"></i>
                  </button>
              </td>
          `;
          this.elements.guardianTableBody.appendChild(row);
      });

      // Adiciona event listeners aos botões
      document.querySelectorAll('.edit-btn').forEach(btn => {
          btn.addEventListener('click', () => this.editGuardian(btn.dataset.id));
      });

      document.querySelectorAll('.delete-btn').forEach(btn => {
          btn.addEventListener('click', () => this.deleteGuardian(btn.dataset.id));
      });
  }

  showErrorInTable(message) {
      this.elements.guardianTableBody.innerHTML = `
          <tr>
              <td colspan="5" class="text-center error-message">
                  ${message || 'Erro ao carregar lista de encarregados'}
              </td>
          </tr>
      `;
  }

  async editGuardian(id) {
      try {
          const response = await fetch(`api/guardians.php?action=get&id=${id}`);
          
          if (!response.ok) {
              throw new Error(`Erro HTTP: ${response.status}`);
          }

          const result = await response.json();
          
          if (!result.success || !result.data) {
              throw new Error(result.message || 'Dados do encarregado não encontrados');
          }

          const guardian = result.data;
          this.fillEditForm(guardian);
          this.openEditModal();
          
      } catch (error) {
          console.error('Error editing guardian:', error);
          this.showAlert('error', error.message);
      }
  }

  fillEditForm(guardian) {
      this.state.currentGuardianId = guardian.id;
      document.getElementById('guardian-id').value = guardian.id;
      document.getElementById('guardian-name').value = guardian.name;
      document.getElementById('guardian-gender').value = guardian.gender || '';
      document.getElementById('guardian-dob').value = guardian.dob || '';
      document.getElementById('bi-number').value = guardian.bi_number || '';
      document.getElementById('guardian-address').value = guardian.address || '';
      document.getElementById('guardian-contact').value = guardian.contact || '';
      document.getElementById('guardian-email').value = guardian.email || '';
  }

  openEditModal() {
      document.getElementById('guardian-modal-title').textContent = 'Editar Encarregado';
      this.elements.guardianModal.style.display = 'block';
  }

  openAddGuardianModal() {
      this.elements.guardianForm.reset();
      this.state.currentGuardianId = null;
      document.getElementById('guardian-modal-title').textContent = 'Adicionar Encarregado';
      this.elements.guardianModal.style.display = 'block';
  }

  closeGuardianModal() {
      this.elements.guardianModal.style.display = 'none';
  }

  async deleteGuardian(id) {
      if (!confirm('Tem certeza que deseja excluir este encarregado?')) return;

      try {
          const response = await fetch(`api/guardians.php?action=delete&id=${id}`, {
              method: 'DELETE'
          });
          
          if (!response.ok) {
              throw new Error(`Erro HTTP: ${response.status}`);
          }

          const result = await response.json();
          
          if (!result.success) {
              throw new Error(result.message || 'Erro ao excluir encarregado');
          }

          this.showAlert('success', result.message);
          this.loadGuardians();
          
      } catch (error) {
          console.error('Error deleting guardian:', error);
          this.showAlert('error', error.message);
      }
  }

  async handleFormSubmit(e) {
      e.preventDefault();
      
      if (this.state.isSubmitting) return;
      if (!this.validateForm()) return;

      const submitBtn = e.target.querySelector('.save-btn');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
      this.state.isSubmitting = true;

      try {
          const formData = this.getFormData();
          const action = this.state.currentGuardianId ? 'update' : 'create';

          const response = await fetch(`api/guardians.php?action=${action}`, {
              method: 'POST',
              headers: { 'Content-Type': 'application/json' },
              body: JSON.stringify(formData)
          });

          if (!response.ok) {
              throw new Error(`Erro HTTP: ${response.status}`);
          }

          const result = await response.json();
          
          if (!result.success) {
              throw new Error(result.message || 'Erro ao salvar encarregado');
          }

          this.showAlert('success', result.message);
          this.closeGuardianModal();
          this.loadGuardians();
          
      } catch (error) {
          console.error('Error submitting form:', error);
          this.showAlert('error', error.message);
          
      } finally {
          submitBtn.disabled = false;
          submitBtn.innerHTML = 'Salvar';
          this.state.isSubmitting = false;
      }
  }

  validateForm() {
      // Implemente suas validações aqui
      const name = document.getElementById('guardian-name').value.trim();
      const contact = document.getElementById('guardian-contact').value.trim();
      
      if (!name) {
          this.showAlert('error', 'O nome é obrigatório');
          return false;
      }
      
      if (!contact) {
          this.showAlert('error', 'O contato é obrigatório');
          return false;
      }
      
      return true;
  }

  getFormData() {
      return {
          id: this.state.currentGuardianId,
          name: document.getElementById('guardian-name').value.trim(),
          gender: document.getElementById('guardian-gender').value,
          dob: document.getElementById('guardian-dob').value,
          bi_number: document.getElementById('bi-number').value.trim(),
          address: document.getElementById('guardian-address').value.trim(),
          contact: document.getElementById('guardian-contact').value.trim(),
          email: document.getElementById('guardian-email').value.trim()
      };
  }

  showAlert(type, message) {
      // Implemente um sistema de alerta mais sofisticado se necessário
      alert(`${type.toUpperCase()}: ${message}`);
  }
}

// Inicialização
document.addEventListener('DOMContentLoaded', () => {
  new GuardiansManager();
});


// Novo código

// Funcionalidade para a barra lateral
document.addEventListener('DOMContentLoaded', function() {
    // Toggle para submenus
    const menuItems = document.querySelectorAll('.has-submenu .menu-item');
    
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            const parent = this.parentElement;
            const submenu = this.nextElementSibling;
            const arrow = this.querySelector('.arrow');
            
            // Verificar se o submenu está aberto
            const isOpen = submenu.classList.contains('show');
            
            // Fechar todos os submenus
            document.querySelectorAll('.submenu').forEach(menu => {
                menu.classList.remove('show');
            });
            
            document.querySelectorAll('.arrow').forEach(arr => {
                arr.style.transform = 'rotate(0deg)';
            });
            
            // Abrir o submenu clicado se estava fechado
            if (!isOpen) {
                submenu.classList.add('show');
                if (arrow) {
                    arrow.style.transform = 'rotate(180deg)';
                }
            }
        });
    });
    
    // Marcar o item ativo com base na URL atual
    const currentPath = window.location.pathname;
    const filename = currentPath.substring(currentPath.lastIndexOf('/') + 1);
    
    document.querySelectorAll('.nav-links li').forEach(item => {
        const link = item.querySelector('a');
        if (link && link.getAttribute('href') === filename) {
            // Marcar o item como ativo
            item.classList.add('active');
            
            // Se for um submenu, abrir o menu pai
            const parentMenu = item.closest('.submenu');
            if (parentMenu) {
                parentMenu.classList.add('show');
                const parentItem = parentMenu.previousElementSibling;
                if (parentItem && parentItem.querySelector('.arrow')) {
                    parentItem.querySelector('.arrow').style.transform = 'rotate(180deg)';
                }
            }
        }
    });
});

// Função para mostrar notificações
function showNotification(message, type = 'success') {
    // Criar elemento de notificação
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <span>${message}</span>
            <button class="close-notification">&times;</button>
        </div>
    `;
    
    // Adicionar ao corpo do documento
    document.body.appendChild(notification);
    
    // Mostrar a notificação
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    // Configurar o botão de fechar
    const closeButton = notification.querySelector('.close-notification');
    closeButton.addEventListener('click', () => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    });
    
    // Fechar automaticamente após 5 segundos
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 5000);
}

// Função para validar formulários
function validateForm(form) {
    let isValid = true;
    
    // Verificar campos obrigatórios
    form.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('error');
            
            // Adicionar mensagem de erro se não existir
            let errorMsg = field.nextElementSibling;
            if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                errorMsg = document.createElement('div');
                errorMsg.className = 'error-message';
                errorMsg.textContent = 'Este campo é obrigatório';
                field.parentNode.insertBefore(errorMsg, field.nextSibling);
            }
        } else {
            field.classList.remove('error');
            
            // Remover mensagem de erro se existir
            const errorMsg = field.nextElementSibling;
            if (errorMsg && errorMsg.classList.contains('error-message')) {
                errorMsg.remove();
            }
        }
    });
    
    return isValid;
}

// Função para formatar dados de formulário para JSON
function formToJSON(form) {
    const data = {};
    const formData = new FormData(form);
    
    for (const [key, value] of formData.entries()) {
        data[key] = value;
    }
    
    return data;
}

// Função para confirmar ações
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

// Exportar funções úteis
window.utils = {
    showNotification,
    validateForm,
    formToJSON,
    confirmAction
};