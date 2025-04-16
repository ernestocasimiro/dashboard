// guardians.js

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
      // Modal events
      this.elements.addGuardianBtn?.addEventListener('click', () => this.openAddGuardianModal());
      this.elements.closeModal?.addEventListener('click', () => this.closeGuardianModal());
      this.elements.cancelBtn?.addEventListener('click', () => this.closeGuardianModal());
      this.elements.guardianForm?.addEventListener('submit', (e) => this.handleFormSubmit(e));
  
      // Close modal when clicking outside
      window.addEventListener('click', (event) => {
        if (event.target === this.elements.guardianModal) {
          this.closeGuardianModal();
        }
      });
    }
  
    openAddGuardianModal() {
      this.elements.guardianForm.reset();
      this.state.currentGuardianId = null;
      document.getElementById('guardian-modal-title').textContent = 'Adicionar Novo Encarregado';
      this.elements.guardianModal.style.display = 'block';
    }
  
    closeGuardianModal() {
      this.elements.guardianModal.style.display = 'none';
    }
  
    async loadGuardians() {
      try {
        const response = await fetch('api/guardians.php?action=getAll');
        const data = await response.json();
        
        this.elements.guardianTableBody.innerHTML = '';
        
        data.forEach(guardian => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${guardian.id}</td>
            <td>${guardian.name}</td>
            <td>${guardian.student_name || 'N/A'}</td>
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
        
        // Add event listeners for action buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
          btn.addEventListener('click', () => this.editGuardian(btn.dataset.id));
        });
        
        document.querySelectorAll('.delete-btn').forEach(btn => {
          btn.addEventListener('click', () => this.deleteGuardian(btn.dataset.id));
        });
      } catch (error) {
        console.error('Error loading guardians:', error);
        this.showAlert('error', 'Erro ao carregar lista de encarregados');
      }
    }
  
    async editGuardian(id) {
      try {
        const response = await fetch(`api/guardians.php?action=get&id=${id}`);
        const data = await response.json();
        
        this.state.currentGuardianId = data.id;
        document.getElementById('guardian-id').value = data.id;
        document.getElementById('guardian-name').value = data.name;
        document.getElementById('guardian-gender').value = data.gender;
        document.getElementById('guardian-dob').value = data.dob;
        document.getElementById('bi-number').value = data.bi_number;
        document.getElementById('guardian-address').value = data.address;
        document.getElementById('guardian-contact').value = data.contact.replace(data.country_code, '');
        document.getElementById('guardian-email').value = data.email;
        
        document.getElementById('guardian-modal-title').textContent = 'Editar Encarregado';
        this.elements.guardianModal.style.display = 'block';
      } catch (error) {
        console.error('Error editing guardian:', error);
        this.showAlert('error', 'Erro ao carregar dados do encarregado');
      }
    }
  
    async deleteGuardian(id) {
      if (!confirm('Tem certeza que deseja excluir este encarregado?')) return;
      
      try {
        const response = await fetch(`api/guardians.php?action=delete&id=${id}`, {
          method: 'DELETE'
        });
        const data = await response.json();
        
        if (data.success) {
          this.showAlert('success', 'Encarregado excluído com sucesso');
          this.loadGuardians();
        } else {
          throw new Error(data.message || 'Erro ao excluir encarregado');
        }
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
        
        if (!response.ok) throw new Error('Erro na rede');
        
        const data = await response.json();
        
        if (data.success) {
          this.showAlert('success', data.message || 'Encarregado salvo com sucesso!');
          this.closeGuardianModal();
          this.loadGuardians();
        } else {
          throw new Error(data.message || 'Erro ao salvar encarregado');
        }
      } catch (error) {
        console.error('Error submitting form:', error);
        this.showAlert('error', error.message || 'Ocorreu um erro ao comunicar com o servidor');
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Salvar Encarregado';
        this.state.isSubmitting = false;
      }
    }
  
    validateForm() {
      const name = document.getElementById('guardian-name').value.trim();
      const contact = document.getElementById('guardian-contact').value.trim();
      
      if (!name) {
        this.showAlert('error', 'Por favor, insira o nome do encarregado');
        return false;
      }
      
      if (!contact || contact.replace(/\D/g, '').length < 8) {
        this.showAlert('error', 'Por favor, insira um número de contato válido');
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
        contact: document.getElementById('country-code').value + 
                document.getElementById('guardian-contact').value.replace(/\D/g, ''),
        email: document.getElementById('guardian-email').value.trim()
      };
    }
  
    showAlert(type, message) {
      const alertDiv = document.createElement('div');
      alertDiv.className = `alert alert-${type}`;
      alertDiv.innerHTML = `
        <span>${message}</span>
        <button class="close-alert">&times;</button>
      `;
      
      document.body.appendChild(alertDiv);
      
      // Auto-close after 5 seconds
      setTimeout(() => {
        alertDiv.classList.add('fade-out');
        setTimeout(() => alertDiv.remove(), 300);
      }, 5000);
      
      // Close on click
      alertDiv.querySelector('.close-alert').addEventListener('click', () => {
        alertDiv.classList.add('fade-out');
        setTimeout(() => alertDiv.remove(), 300);
      });
    }
  }
  
  // Initialize when DOM is ready
  document.addEventListener('DOMContentLoaded', () => {
    new GuardiansManager();
  });