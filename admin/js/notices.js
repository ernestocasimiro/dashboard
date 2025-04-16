document.addEventListener("DOMContentLoaded", () => {
    // Get DOM elements
    const newNoticeBtn = document.querySelector(".btn-new-notice")
    const noticeModal = document.getElementById("noticeModal")
    const closeModalBtn = document.querySelector(".close-modal")
    const noticeFilter = document.getElementById("noticeFilter")
    const audienceFilter = document.getElementById("audienceFilter")
    const noticeCards = document.querySelectorAll(".notice-card")
  
    // Toggle notice modal
    if (newNoticeBtn && noticeModal) {
      newNoticeBtn.addEventListener("click", () => {
        noticeModal.style.display = "flex"
      })
    }
  
    // Close modal
    if (closeModalBtn && noticeModal) {
      closeModalBtn.addEventListener("click", () => {
        noticeModal.style.display = "none"
      })
  
      // Close modal when clicking outside
      window.addEventListener("click", (event) => {
        if (event.target === noticeModal) {
          noticeModal.style.display = "none"
        }
      })
    }
  
    // Notice filter change handler
    if (noticeFilter) {
      noticeFilter.addEventListener("change", function () {
        const filter = this.value
  
        // Show all notices first
        noticeCards.forEach((card) => {
          card.style.display = "flex"
        })
  
        // If filter is not 'all', hide notices that don't match the filter
        if (filter !== "all") {
          noticeCards.forEach((card) => {
            if (!card.classList.contains(filter)) {
              card.style.display = "none"
            }
          })
        }
      })
    }
  
    // Audience filter change handler
    if (audienceFilter) {
      audienceFilter.addEventListener("change", function () {
        const filter = this.value
  
        // Show all notices first
        noticeCards.forEach((card) => {
          card.style.display = "flex"
        })
  
        // If filter is not 'all', hide notices that don't have the audience tag
        if (filter !== "all") {
          noticeCards.forEach((card) => {
            const audienceTags = card.querySelectorAll(".audience-tag")
            let hasAudience = false
  
            audienceTags.forEach((tag) => {
              if (tag.textContent.toLowerCase() === filter) {
                hasAudience = true
              }
            })
  
            if (!hasAudience) {
              card.style.display = "none"
            }
          })
        }
      })
    }
  
    // Handle notice form submission
    const noticeForm = document.getElementById("noticeForm")
  
    if (noticeForm) {
      noticeForm.addEventListener("submit", (event) => {
        event.preventDefault()
  
        const title = document.getElementById("noticeTitle").value
        const type = document.getElementById("noticeType").value
        const content = document.getElementById("noticeContent").value
        const publishDate = document.getElementById("publishDate").value
        const expiryDate = document.getElementById("expiryDate").value
  
        // Get selected audiences
        const audiences = []
        const audienceCheckboxes = document.querySelectorAll('input[name="audience"]:checked')
        audienceCheckboxes.forEach((checkbox) => {
          audiences.push(checkbox.value)
        })
  
        if (
          title.trim() === "" ||
          content.trim() === "" ||
          publishDate === "" ||
          expiryDate === "" ||
          audiences.length === 0
        ) {
          alert("Por favor, preencha todos os campos obrigatórios.")
          return
        }
  
        // In a real application, you would send the notice to the server
        console.log("Notice published:", {
          title,
          type,
          content,
          publishDate,
          expiryDate,
          audiences,
        })
  
        // Clear the form
        noticeForm.reset()
  
        // Close the modal
        noticeModal.style.display = "none"
  
        // Show a success message
        alert("Aviso publicado com sucesso!")
      })
    }
  
    // Edit notice functionality
    const editButtons = document.querySelectorAll('.notice-actions .action-btn[title="Editar"]')
  
    editButtons.forEach((button) => {
      button.addEventListener("click", function (event) {
        event.stopPropagation()
  
        // Get the notice card
        const noticeCard = this.closest(".notice-card")
  
        // Get notice details
        const title = noticeCard.querySelector(".notice-title h3").textContent
        const content = noticeCard.querySelector(".notice-content").innerHTML
  
        // In a real application, you would populate the form with the notice details
        // and open the modal for editing
  
        // For this demo, we'll just show an alert
        alert("Editar aviso: " + title)
  
        // Open the modal
        noticeModal.style.display = "flex"
  
        // Populate the form (in a real app, you would get this data from the server)
        document.getElementById("noticeTitle").value = title
        document.getElementById("noticeContent").value = content.replace(/<[^>]*>/g, "")
      })
    })
  
    // Delete notice functionality
    const deleteButtons = document.querySelectorAll('.notice-actions .action-btn[title="Excluir"]')
  
    deleteButtons.forEach((button) => {
      button.addEventListener("click", function (event) {
        event.stopPropagation()
  
        // Get the notice card
        const noticeCard = this.closest(".notice-card")
  
        // Get notice title
        const title = noticeCard.querySelector(".notice-title h3").textContent
  
        // Confirm deletion
        if (confirm(`Tem certeza que deseja excluir o aviso "${title}"?`)) {
          // In a real application, you would send a delete request to the server
  
          // For this demo, we'll just remove the card from the DOM
          noticeCard.remove()
  
          // Show a success message
          alert("Aviso excluído com sucesso!")
        }
      })
    })
  })
  