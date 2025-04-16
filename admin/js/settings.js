document.addEventListener("DOMContentLoaded", () => {
    // Get DOM elements
    const settingsNavItems = document.querySelectorAll(".settings-nav-item")
    const settingsSections = document.querySelectorAll(".settings-section")
    const formTabs = document.querySelectorAll(".form-tab")
    const formTabContents = document.querySelectorAll(".form-tab-content")
    const saveAllBtn = document.querySelector(".btn-save-all")
    const saveSectionBtns = document.querySelectorAll(".btn-save-section")
    const addRoleBtn = document.querySelector(".btn-add-role")
    const addPeriodBtn = document.querySelector(".btn-add-period")
    const editRoleBtns = document.querySelectorAll(".btn-edit-role")
    const deleteRoleBtns = document.querySelectorAll(".btn-delete-role")
    const editPeriodBtns = document.querySelectorAll(".btn-edit-period")
    const uploadBtns = document.querySelectorAll(".btn-upload")
    const removeBtns = document.querySelectorAll(".btn-remove")
    const backupNowBtn = document.querySelector(".btn-backup-now")
    const restoreBtn = document.querySelector(".btn-restore")
    const viewLogsBtn = document.querySelector(".btn-view-logs")
    const downloadLogsBtn = document.querySelector(".btn-download-logs")
    const clearLogsBtn = document.querySelector(".btn-clear-logs")
    const maintenanceBtn = document.querySelector(".btn-maintenance")
    const optimizeBtn = document.querySelector(".btn-optimize")
  
    // Settings navigation
    if (settingsNavItems.length > 0 && settingsSections.length > 0) {
      settingsNavItems.forEach((item) => {
        item.addEventListener("click", function () {
          // Remove active class from all nav items and sections
          settingsNavItems.forEach((navItem) => navItem.classList.remove("active"))
          settingsSections.forEach((section) => section.classList.remove("active"))
  
          // Add active class to clicked nav item
          this.classList.add("active")
  
          // Show the corresponding section
          const sectionId = this.getAttribute("data-section")
          const section = document.getElementById(sectionId)
          if (section) {
            section.classList.add("active")
          }
        })
      })
    }
  
    // Form tabs
    if (formTabs.length > 0 && formTabContents.length > 0) {
      formTabs.forEach((tab) => {
        tab.addEventListener("click", function () {
          // Get the parent form-tabs container
          const tabsContainer = this.closest(".form-tabs")
          if (!tabsContainer) return
  
          // Get all tabs and tab contents within this container
          const tabs = tabsContainer.querySelectorAll(".form-tab")
          const tabContents = this.closest(".settings-form").querySelectorAll(".form-tab-content")
  
          // Remove active class from all tabs and tab contents
          tabs.forEach((t) => t.classList.remove("active"))
          tabContents.forEach((c) => c.classList.remove("active"))
  
          // Add active class to clicked tab
          this.classList.add("active")
  
          // Show the corresponding tab content
          const tabId = this.getAttribute("data-tab")
          const tabContent = document.getElementById(tabId + "-tab")
          if (tabContent) {
            tabContent.classList.add("active")
          }
        })
      })
    }
  
    // Save all settings
    if (saveAllBtn) {
      saveAllBtn.addEventListener("click", () => {
        // In a real application, you would collect all form data and send it to the server
        // For this demo, we'll just show a success message
        showNotification("Todas as configurações foram salvas com sucesso!")
      })
    }
  
    // Save section
    if (saveSectionBtns.length > 0) {
      saveSectionBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
          // Get the section name from the closest section
          const section = this.closest(".settings-section")
          const sectionName = section.id
  
          // In a real application, you would collect the form data for this section and send it to the server
          // For this demo, we'll just show a success message
          showNotification(`Configurações de ${getSectionName(sectionName)} salvas com sucesso!`)
        })
      })
    }
  
    // Add role
    if (addRoleBtn) {
      addRoleBtn.addEventListener("click", () => {
        // In a real application, you would open a modal to add a new role
        // For this demo, we'll just show an alert
        alert("Funcionalidade de adicionar nova função não disponível nesta versão de demonstração.")
      })
    }
  
    // Add period
    if (addPeriodBtn) {
      addPeriodBtn.addEventListener("click", () => {
        // In a real application, you would open a modal to add a new period
        // For this demo, we'll just show an alert
        alert("Funcionalidade de adicionar novo período não disponível nesta versão de demonstração.")
      })
    }
  
    // Edit role
    if (editRoleBtns.length > 0) {
      editRoleBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
          // Get the role name
          const roleItem = this.closest(".role-item")
          const roleName = roleItem.querySelector("h4").textContent
  
          // In a real application, you would open a modal to edit the role
          // For this demo, we'll just show an alert
          alert(`Editar função: ${roleName}`)
        })
      })
    }
  
    // Delete role
    if (deleteRoleBtns.length > 0) {
      deleteRoleBtns.forEach((btn) => {
        if (!btn.disabled) {
          btn.addEventListener("click", function () {
            // Get the role name
            const roleItem = this.closest(".role-item")
            const roleName = roleItem.querySelector("h4").textContent
  
            // Confirm deletion
            if (confirm(`Tem certeza que deseja excluir a função "${roleName}"?`)) {
              // In a real application, you would send a delete request to the server
              // For this demo, we'll just remove the role item from the DOM
              roleItem.remove()
              showNotification(`Função "${roleName}" excluída com sucesso!`)
            }
          })
        }
      })
    }
  
    // Edit period
    if (editPeriodBtns.length > 0) {
      editPeriodBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
          // Get the period name
          const periodItem = this.closest(".period-item")
          const periodName = periodItem.querySelector("h4").textContent
  
          // In a real application, you would open a modal to edit the period
          // For this demo, we'll just show an alert
          alert(`Editar período: ${periodName}`)
        })
      })
    }
  
    // Upload buttons
    if (uploadBtns.length > 0) {
      uploadBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
          // In a real application, you would open a file picker
          // For this demo, we'll just show an alert
          alert("Funcionalidade de upload não disponível nesta versão de demonstração.")
        })
      })
    }
  
    // Remove buttons
    if (removeBtns.length > 0) {
      removeBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
          // In a real application, you would remove the image and update the UI
          // For this demo, we'll just show an alert
          alert("Funcionalidade de remoção não disponível nesta versão de demonstração.")
        })
      })
    }
  
    // Backup now
    if (backupNowBtn) {
      backupNowBtn.addEventListener("click", () => {
        // In a real application, you would trigger a backup process
        // For this demo, we'll just show a success message
        showNotification("Backup iniciado. Você será notificado quando for concluído.")
      })
    }
  
    // Restore
    if (restoreBtn) {
      restoreBtn.addEventListener("click", () => {
        // In a real application, you would open a file picker to select a backup file
        // For this demo, we'll just show an alert
        alert("Funcionalidade de restauração não disponível nesta versão de demonstração.")
      })
    }
  
    // View logs
    if (viewLogsBtn) {
      viewLogsBtn.addEventListener("click", () => {
        // In a real application, you would open a modal or navigate to a logs page
        // For this demo, we'll just show an alert
        alert("Funcionalidade de visualização de logs não disponível nesta versão de demonstração.")
      })
    }
  
    // Download logs
    if (downloadLogsBtn) {
      downloadLogsBtn.addEventListener("click", () => {
        // In a real application, you would trigger a download of the logs
        // For this demo, we'll just show a success message
        showNotification("Download dos logs iniciado.")
      })
    }
  
    // Clear logs
    if (clearLogsBtn) {
      clearLogsBtn.addEventListener("click", () => {
        // Confirm clearing logs
        if (confirm("Tem certeza que deseja limpar todos os logs do sistema?")) {
          // In a real application, you would send a request to clear the logs
          // For this demo, we'll just show a success message
          showNotification("Logs do sistema foram limpos com sucesso.")
        }
      })
    }
  
    // Maintenance mode
    if (maintenanceBtn) {
      maintenanceBtn.addEventListener("click", () => {
        // Confirm entering maintenance mode
        if (
          confirm(
            "Tem certeza que deseja ativar o modo de manutenção? O sistema ficará indisponível para todos os usuários exceto administradores.",
          )
        ) {
          // In a real application, you would send a request to enable maintenance mode
          // For this demo, we'll just show a success message
          showNotification("Modo de manutenção ativado.")
        }
      })
    }
  
    // Optimize system
    if (optimizeBtn) {
      optimizeBtn.addEventListener("click", () => {
        // In a real application, you would trigger system optimization
        // For this demo, we'll just show a success message
        showNotification("Otimização do sistema iniciada. Isso pode levar alguns minutos.")
      })
    }
  
    // Helper function to show notifications
    function showNotification(message) {
      // Create notification element
      const notification = document.createElement("div")
      notification.className = "notification"
      notification.innerHTML = `
        <div class="notification-content">
          <i class="fas fa-check-circle"></i>
          <span>${message}</span>
        </div>
        <button class="notification-close"><i class="fas fa-times"></i></button>
      `
  
      // Add styles
      notification.style.position = "fixed"
      notification.style.bottom = "20px"
      notification.style.right = "20px"
      notification.style.backgroundColor = "#4caf50"
      notification.style.color = "white"
      notification.style.padding = "12px 20px"
      notification.style.borderRadius = "4px"
      notification.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)"
      notification.style.display = "flex"
      notification.style.alignItems = "center"
      notification.style.justifyContent = "space-between"
      notification.style.minWidth = "300px"
      notification.style.zIndex = "1000"
      notification.style.animation = "slideIn 0.3s ease-out forwards"
  
      // Add animation keyframes
      const style = document.createElement("style")
      style.innerHTML = `
        @keyframes slideIn {
          from { transform: translateX(100%); opacity: 0; }
          to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
          from { transform: translateX(0); opacity: 1; }
          to { transform: translateX(100%); opacity: 0; }
        }
      `
      document.head.appendChild(style)
  
      // Add notification to the DOM
      document.body.appendChild(notification)
  
      // Close button functionality
      const closeBtn = notification.querySelector(".notification-close")
      closeBtn.addEventListener("click", () => {
        notification.style.animation = "slideOut 0.3s ease-out forwards"
        setTimeout(() => {
          notification.remove()
        }, 300)
      })
  
      // Auto-close after 5 seconds
      setTimeout(() => {
        if (document.body.contains(notification)) {
          notification.style.animation = "slideOut 0.3s ease-out forwards"
          setTimeout(() => {
            notification.remove()
          }, 300)
        }
      }, 5000)
    }
  
    // Helper function to get section name
    function getSectionName(sectionId) {
      switch (sectionId) {
        case "school-info":
          return "Informações da Escola"
        case "users-permissions":
          return "Usuários e Permissões"
        case "academic-settings":
          return "Configurações Acadêmicas"
        case "notifications":
          return "Notificações"
        case "appearance":
          return "Aparência"
        case "system":
          return "Sistema"
        default:
          return "Configurações"
      }
    }
  })
  