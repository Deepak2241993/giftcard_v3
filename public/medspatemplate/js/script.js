function navigateWeek(direction) {
  const action = direction === 1 ? "next" : "previous"
  console.log(`Navigating to ${action} week`)


  const buttons = document.querySelectorAll(".nav-btn")
  const clickedButton = direction === 1 ? document.querySelector(".next-btn") : document.querySelector(".prev-btn")


  clickedButton.style.transform = "scale(0.9)"
  clickedButton.style.background = "var(--primary-color)"
  clickedButton.style.color = "white"

  setTimeout(() => {
    clickedButton.style.transform = "scale(1.05)"
    setTimeout(() => {
      clickedButton.style.transform = ""
      clickedButton.style.background = ""
      clickedButton.style.color = ""
    }, 150)
  }, 100)

  
  const scheduleItems = document.querySelectorAll(".schedule-item")
  scheduleItems.forEach((item, index) => {
    setTimeout(() => {
      item.style.transform = "translateX(-10px)"
      item.style.opacity = "0.7"
      setTimeout(() => {
        item.style.transform = ""
        item.style.opacity = ""
      }, 200)
    }, index * 50)
  })
}


function toggleReadMore(button) {
  const serviceCard = button.closest(".service-card")
  const hiddenContent = serviceCard.querySelector(".hidden-content")
  const icon = button.querySelector("i")
  const span = button.querySelector("span")

  if (hiddenContent.classList.contains("expanded")) {
    
    hiddenContent.classList.remove("expanded")
    button.classList.remove("expanded")
    span.textContent = "Read More"
    icon.style.transform = "rotate(0deg)"
  } else {
    hiddenContent.classList.add("expanded")
    button.classList.add("expanded")
    span.textContent = "Read Less"
    icon.style.transform = "rotate(180deg)"
  }

  createRipple(button)
}

function createRipple(element) {
  const ripple = document.createElement("span")
  const rect = element.getBoundingClientRect()
  const size = Math.max(rect.width, rect.height)

  ripple.style.width = ripple.style.height = size + "px"
  ripple.style.left = rect.width / 2 - size / 2 + "px"
  ripple.style.top = rect.height / 2 - size / 2 + "px"
  ripple.classList.add("ripple")

  element.style.position = "relative"
  element.style.overflow = "hidden"
  element.appendChild(ripple)

  setTimeout(() => {
    ripple.remove()
  }, 600)
}

const rippleCSS = `
.ripple {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    transform: scale(0);
    animation: ripple-animation 0.6s linear;
    pointer-events: none;
}

@keyframes ripple-animation {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`

const style = document.createElement("style")
style.textContent = rippleCSS
document.head.appendChild(style)

let currentSearchResults = []
let selectedResultIndex = -1


document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("serviceSearch")
  const clearButton = document.getElementById("clearSearch")
  const searchDropdown = document.getElementById("searchDropdown")

  searchInput.addEventListener("keydown", handleKeyNavigation)



  clearButton.addEventListener("click", clearSearch)

  
  document.addEventListener("click", (e) => {
    if (!e.target.closest(".search-container")) {
      hideSearchDropdown()
    }
  })
})


function displaySearchResults(results) {
  const searchDropdown = document.getElementById("searchDropdown")
  const query = document.getElementById("serviceSearch").value.toLowerCase()

  searchDropdown.innerHTML = results
    .map(
      (service, index) => `
        <div class="search-result-item" data-index="${index}" onclick="selectSearchResult(${index})">
            <div class="search-result-icon">
                <i class="${service.icon}"></i>
            </div>
            <div class="search-result-content">
                <div class="search-result-title">${highlightMatch(service.title, query)}</div>
                <div class="search-result-category">${service.category}</div>
            </div>
        </div>
    `,
    )
    .join("")
}

function displayNoResults() {
  const searchDropdown = document.getElementById("searchDropdown")
  searchDropdown.innerHTML = `
        <div class="no-results">
            <i class="fas fa-search"></i>
            <div>No treatments found</div>
            <div style="font-size: 12px; margin-top: 4px;">Try searching for "Botox", "Laser", or "Facial"</div>
        </div>
    `
}

function highlightMatch(text, query) {
  if (!query) return text
  const regex = new RegExp(`(${query})`, "gi")
  return text.replace(regex, '<span class="search-highlight">$1</span>')
}

function handleKeyNavigation(e) {
  const searchDropdown = document.getElementById("searchDropdown")
  const resultItems = searchDropdown.querySelectorAll(".search-result-item")

  if (resultItems.length === 0) return

  switch (e.key) {
    case "ArrowDown":
      e.preventDefault()
      selectedResultIndex = Math.min(selectedResultIndex + 1, resultItems.length - 1)
      updateSelectedResult(resultItems)
      break
    case "ArrowUp":
      e.preventDefault()
      selectedResultIndex = Math.max(selectedResultIndex - 1, -1)
      updateSelectedResult(resultItems)
      break
    case "Enter":
      e.preventDefault()
      if (selectedResultIndex >= 0) {
        selectSearchResult(selectedResultIndex)
      }
      break
    case "Escape":
      hideSearchDropdown()
      break
  }
}

function updateSelectedResult(resultItems) {
  resultItems.forEach((item, index) => {
    if (index === selectedResultIndex) {
      item.classList.add("active")
    } else {
      item.classList.remove("active")
    }
  })
}

function selectSearchResult(index) {
  const selectedService = currentSearchResults[index]
  const searchInput = document.getElementById("serviceSearch")

  searchInput.value = selectedService.title
  hideSearchDropdown()

  
  updateServiceCards(selectedService)

  
  showNotification(`Selected: ${selectedService.title}`, "success")
}

function handleSearchFocus() {
  const query = document.getElementById("serviceSearch").value.trim()
  if (query.length >= 2 && currentSearchResults.length > 0) {
    showSearchDropdown()
  }
}

function clearSearch() {
  const searchInput = document.getElementById("serviceSearch")
  const clearButton = document.getElementById("clearSearch")

  searchInput.value = ""
  clearButton.style.display = "none"
  hideSearchDropdown()
  resetServiceCards()
  searchInput.focus()
}

function showSearchDropdown() {
  const searchDropdown = document.getElementById("searchDropdown")
  searchDropdown.classList.add("show")
}

function hideSearchDropdown() {
  const searchDropdown = document.getElementById("searchDropdown")
  searchDropdown.classList.remove("show")
  selectedResultIndex = -1
}

function filterServiceCards(results) {
  const serviceCards = document.querySelectorAll(".service-card")
  const resultIds = results.map((r) => r.id)

  serviceCards.forEach((card, index) => {
    const cardId = index === 0 ? "botox-new" : "botox-repeat" 

    if (results.length === 0) {
      card.classList.add("filtered")
      card.classList.remove("highlighted")
    } else {
      card.classList.remove("filtered")
      if (
        results.some((r) =>
          r.keywords.some((k) => document.getElementById("serviceSearch").value.toLowerCase().includes(k)),
        )
      ) {
        card.classList.add("highlighted")
      } else {
        card.classList.remove("highlighted")
      }
    }
  })
}

function hideAllServiceCards() {
  const serviceCards = document.querySelectorAll(".service-card")
  serviceCards.forEach((card) => {
    card.classList.add("filtered")
    card.classList.remove("highlighted")
  })
}

function resetServiceCards() {
  const serviceCards = document.querySelectorAll(".service-card")
  serviceCards.forEach((card) => {
    card.classList.remove("filtered", "highlighted")
  })
}

function updateServiceCards(selectedService) {
  const serviceCards = document.querySelectorAll(".service-card")
  const serviceIcons = document.querySelectorAll(".service-icon i")
  const serviceTitles = document.querySelectorAll(".service-card h3")

  
  if (serviceIcons[0] && serviceTitles[0]) {
    serviceIcons[0].className = selectedService.icon
    serviceTitles[0].textContent = selectedService.title
  }

  
  updateRelatedServices(selectedService.category)

  serviceCards.forEach((card, index) => {
    setTimeout(() => {
      card.style.transform = "scale(1.02)"
      setTimeout(() => {
        card.style.transform = ""
      }, 200)
    }, index * 100)
  })
}



document.addEventListener("DOMContentLoaded", () => {
  const categoryItems = document.querySelectorAll(".category-item")

  categoryItems.forEach((item) => {
    item.addEventListener("click", () => {
      const category = item.dataset.category
      selectCategory(category, item)
    })
  })
})

let allCategories = []
const filteredCategories = []

document.addEventListener("DOMContentLoaded", () => {
  const categorySearchInput = document.getElementById("categorySearch")
  const clearCategorySearchBtn = document.getElementById("clearCategorySearch")

  allCategories = Array.from(document.querySelectorAll(".category-item")).map((item) => ({
    element: item,
    name: item.querySelector("h4").textContent,
    category: item.dataset.category,
  }))

  if (categorySearchInput) {
    categorySearchInput.addEventListener("input", handleCategorySearch)
    categorySearchInput.addEventListener("focus", handleCategorySearchFocus)
  }

  if (clearCategorySearchBtn) {
    clearCategorySearchBtn.addEventListener("click", clearCategorySearch)
  }
})

function handleCategorySearch(e) {
  const query = e.target.value.trim()
  const clearButton = document.getElementById("clearCategorySearch")

 
  if (query.length > 0) {
    clearButton.style.display = "block"
  } else {
    clearButton.style.display = "none"
    resetCategoryFilter()
    return
  }

  filterCategories(query)
}

function filterCategories(query) {
  const searchTerm = query.toLowerCase()

  allCategories.forEach((categoryData) => {
    const categoryName = categoryData.name.toLowerCase()

    if (categoryName.includes(searchTerm)) {
      categoryData.element.classList.remove("filtered")
    } else {
      categoryData.element.classList.add("filtered")
    }
  })
}

// for clear search data
function resetCategoryFilter() {
  allCategories.forEach((categoryData) => {
    categoryData.element.classList.remove("filtered")
  })
}

function clearCategorySearch() {
  const categorySearchInput = document.getElementById("categorySearch")
  const clearButton = document.getElementById("clearCategorySearch")

  categorySearchInput.value = ""
  clearButton.style.display = "none"
  resetCategoryFilter()
  categorySearchInput.focus()
}

function handleCategorySearchFocus() {
  const query = document.getElementById("categorySearch").value.trim()
  if (query.length > 0) {
    filterCategories(query)
  }
}





document.addEventListener("click", (e) => {
  if (e.target.closest(".book-now-btn")) {
    const button = e.target.closest("button")

    const originalText = button.innerHTML
    button.style.background = "var(--success-color)"

    button.style.animation = "pulse 1s ease-in-out"

    setTimeout(() => {
      setTimeout(() => {
        button.innerHTML = originalText
        button.style.background = ""
        button.style.animation = ""
      }, 2000)
    }, 1000)
  }
})
function showNotification(message, type = "info") {
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.innerHTML = `
        <i class="fas fa-${type === "success" ? "check-circle" : "info-circle"}"></i>
        <span>${message}</span>
    `

  document.body.appendChild(notification)


  setTimeout(() => {
    notification.classList.add("show")
  }, 100)

  setTimeout(() => {
    notification.classList.remove("show")
    setTimeout(() => {
      notification.remove()
    }, 300)
  }, 3000)
}

const notificationCSS = `
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    padding: 16px 20px;
    border-radius: 12px;
    box-shadow: var(--shadow-lg);
    display: flex;
    align-items: center;
    gap: 12px;
    transform: translateX(100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    border-left: 4px solid var(--primary-color);
}

.notification.notification-success {
    border-left-color: var(--success-color);
}

.notification.notification-success i {
    color: var(--success-color);
}

.notification.show {
    transform: translateX(0);
}

.notification span {
    font-weight: 500;
    color: var(--text-primary);
}
`

const notificationStyle = document.createElement("style")
notificationStyle.textContent = notificationCSS
document.head.appendChild(notificationStyle)

const observerOptions = {
  threshold: 0.1,
  rootMargin: "0px 0px -50px 0px",
}

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = "1"
      entry.target.style.transform = "translateY(0)"
    }
  })
}, observerOptions)

document.addEventListener("DOMContentLoaded", () => {
  const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
  const today = new Date().getDay()
  const scheduleItems = document.querySelectorAll(".schedule-item")

  scheduleItems.forEach((item, index) => {
    if (index === today) {
      item.classList.add("current")
    }
  })

  const serviceCards = document.querySelectorAll(".service-card")
  serviceCards.forEach((card, index) => {
    card.style.opacity = "0"
    card.style.transform = "translateY(30px)"
    setTimeout(() => {
      card.style.transition = "all 0.6s cubic-bezier(0.4, 0, 0.2, 1)"
      card.style.opacity = "1"
      card.style.transform = "translateY(0)"
    }, index * 200)
  })
  document.querySelectorAll(".service-card, .schedule-item, .contact-item").forEach((el) => {
    observer.observe(el)
  })
})

document.documentElement.style.scrollBehavior = "smooth"

document.querySelectorAll(".schedule-item, .contact-item, .service-card").forEach((item) => {
  item.addEventListener("mouseenter", function () {
    this.style.transform = "translateY(-2px)"
  })

  item.addEventListener("mouseleave", function () {
    this.style.transform = ""
  })
})

function toggleQuantityControls(button) {
  const serviceFooter = button.closest(".service-footer")
  const quantityControls = serviceFooter.querySelector(".quantity-controls")
  const buttonText = button.querySelector("span")
  const buttonIcon = button.querySelector("i")

  if (quantityControls.style.display === "none" || !quantityControls.style.display) {
    quantityControls.style.display = "flex"
    serviceFooter.classList.add("quantity-mode")
    buttonText.textContent = "Add to Cart"
    buttonIcon.className = "fas fa-shopping-cart"
    button.style.background = "var(--success-color)"

    updatePriceDisplay(serviceFooter, 1)

    quantityControls.style.opacity = "0"
    quantityControls.style.transform = "translateY(10px)"
    setTimeout(() => {
      quantityControls.style.transition = "all 0.3s ease-out"
      quantityControls.style.opacity = "1"
      quantityControls.style.transform = "translateY(0)"
    }, 50)
  } else {
    const quantity = Number.parseInt(serviceFooter.querySelector(".quantity-display").textContent)
    const basePrice = Number.parseInt(button.dataset.basePrice)
    const totalPrice = basePrice * quantity
    const serviceName = serviceFooter.closest(".service-card").querySelector("h3").textContent
    const productId = button.dataset.id

    // ✅ Call your AJAX function
    addcart(productId, quantity)

    button.style.background = "var(--success-color)"
    buttonText.textContent = "Added!"
    buttonIcon.className = "fas fa-check"

    setTimeout(() => {
      quantityControls.style.display = "none"
      serviceFooter.classList.remove("quantity-mode")
      buttonText.textContent = "Book Now"
      buttonIcon.className = "fas fa-arrow-right"
      button.style.background = ""

      serviceFooter.querySelector(".quantity-display").textContent = "1"
      updatePriceDisplay(serviceFooter, 1)
    }, 2000)

    showNotification(`Added ${quantity}x ${serviceName} - Total: $${totalPrice}`, "success")
  }
}


function updateQuantity(button, change) {
  const serviceFooter = button.closest(".service-footer")
  const quantityDisplay = serviceFooter.querySelector(".quantity-display")
  const minusBtn = serviceFooter.querySelector(".minus-btn")

  const currentQuantity = Number.parseInt(quantityDisplay.textContent)
  let newQuantity = currentQuantity + change

  if (newQuantity < 1) {
    newQuantity = 1
  }

  quantityDisplay.textContent = newQuantity

  if (newQuantity <= 1) {
    minusBtn.classList.add("disabled")
  } else {
    minusBtn.classList.remove("disabled")
  }

  updatePriceDisplay(serviceFooter, newQuantity)

  quantityDisplay.style.transform = "scale(1.2)"
  setTimeout(() => {
    quantityDisplay.style.transform = "scale(1)"
  }, 150)

  createRipple(button)
}

function updatePriceDisplay(serviceFooter, quantity) {
  const bookButton = serviceFooter.querySelector(".book-now-btn")
  const basePrice = Number.parseInt(bookButton.dataset.basePrice)
  const totalPrice = basePrice * quantity

  const footerPriceDisplays = serviceFooter.querySelectorAll(".price-display")

  footerPriceDisplays.forEach((display) => {
    if (quantity === 1) {
      display.textContent = `From $${basePrice}`
    } else {
      display.textContent = `$${totalPrice} (${quantity}x $${basePrice})`
    }
    display.classList.add("updated")
    setTimeout(() => {
      display.classList.remove("updated")
    }, 300)
  })
}


function showCartNotification(serviceName, quantity, totalPrice) {
  const notification = document.createElement("div")
  notification.className = "notification notification-success cart-notification"
  notification.innerHTML = `
    <i class="fas fa-shopping-cart"></i>
    <div class="notification-content">
      <div class="notification-title">Added to Cart</div>
      <div class="notification-details">${quantity}x ${serviceName} - $${totalPrice}</div>
    </div>
  `

  document.body.appendChild(notification)


  setTimeout(() => {
    notification.classList.add("show")
  }, 100)
  setTimeout(() => {
    notification.classList.remove("show")
    setTimeout(() => {
      notification.remove()
    }, 300)
  }, 4000)
}

const cartNotificationCSS = `
.cart-notification {
  min-width: 350px;
}

.notification-content {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.notification-title {
  font-weight: 600;
  font-size: var(--font-size-sm);
}

.notification-details {
  font-size: var(--font-size-xs);
  color: var(--text-muted);
}
`

const cartNotificationStyle = document.createElement("style")
cartNotificationStyle.textContent = cartNotificationCSS
document.head.appendChild(cartNotificationStyle)


const cartItems = []
let cartCount = 0

function updateCartCount() {
  const cartCountElement = document.getElementById("cartCount")
  const cartIcon = document.getElementById("cartIcon")

  if (cartCount > 0) {
    cartCountElement.textContent = cartCount
    cartIcon.classList.add("has-items")
  } else {
    cartIcon.classList.remove("has-items")
  }
}

function addToCart(serviceName, quantity, price) {
  const existingItem = cartItems.find((item) => item.name === serviceName)

  if (existingItem) {
    existingItem.quantity += quantity
    existingItem.total = existingItem.quantity * existingItem.price
  } else {
    cartItems.push({
      id: Date.now(),
      name: serviceName,
      quantity: quantity,
      price: price,
      total: price * quantity,
    })
  }

  cartCount += quantity
  updateCartCount()
  updateCartSidebar()

 
  const cartIcon = document.getElementById("cartIcon")
  cartIcon.style.transform = "scale(1.2)"
  setTimeout(() => {
    cartIcon.style.transform = "scale(1)"
  }, 200)
}

function removeFromCart(itemId) {
  const itemIndex = cartItems.findIndex((item) => item.id === itemId)
  if (itemIndex > -1) {
    const item = cartItems[itemIndex]
    cartCount -= item.quantity
    cartItems.splice(itemIndex, 1)
    updateCartCount()
    updateCartSidebar()
    showNotification(`Removed ${item.name} from cart`, "success")
  }
}

function updateCartItemQuantity(itemId, newQuantity) {
  const item = cartItems.find((item) => item.id === itemId)
  if (item) {
    const oldQuantity = item.quantity
    item.quantity = newQuantity
    item.total = item.price * newQuantity
    cartCount = cartCount - oldQuantity + newQuantity
    updateCartCount()
    updateCartSidebar()
  }
}

function updateCartSidebar(cartHtml, subtotal, total, cartCountVal) {
}


function clearCart() {
  cartItems.length = 0
  cartCount = 0
  updateCartCount()
  updateCartSidebar()
  showNotification("Cart cleared", "success")
}

function openCartSidebar() {
  const cartSidebar = document.getElementById("cartSidebar")
  cartSidebar.classList.add("open")
  document.body.style.overflow = "hidden"
}

function closeCartSidebar() {
  const cartSidebar = document.getElementById("cartSidebar")
  cartSidebar.classList.remove("open")
  document.body.style.overflow = ""
}

function proceedToCheckout() {
  if (cartItems.length === 0) {
    showNotification("Your cart is empty", "info")
    return
  }

  const total = cartItems.reduce((sum, item) => sum + item.total, 0)
  showNotification(`Proceeding to checkout - Total: $${total}`, "success")


  setTimeout(() => {
    showNotification("Checkout functionality would be implemented here", "info")
  }, 1500)
}

document.addEventListener("DOMContentLoaded", () => {
  updateCartCount()
  updateCartSidebar()

  
  document.getElementById("cartIcon").addEventListener("click", () => {
    openCartSidebar()
  })

  document.getElementById("cartCloseBtn").addEventListener("click", closeCartSidebar)
  document.getElementById("cartSidebarOverlay").addEventListener("click", closeCartSidebar)
  // document.getElementById("clearCartBtn").addEventListener("click", clearCart)
  document.getElementById("checkoutBtn").addEventListener("click", proceedToCheckout)

  
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeCartSidebar()
    }
  })
})
