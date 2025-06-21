AOS.init({
  duration: 1000,
  once: true,
  offset: 100
});

// pricing toggle functionality
document.addEventListener('DOMContentLoaded', function () {
  const monthlyBtn = document.getElementById("monthlyBtn");
  const yearlyBtn = document.getElementById("yearlyBtn");
  const proPrice = document.getElementById("proPrice");
  const premiumPrice = document.getElementById("premiumPrice");
  const pricePeriod = document.querySelectorAll(".price-period");

  // Set initial state to monthly
  if (monthlyBtn) {
    monthlyBtn.classList.add("active");
  }

  // Monthly button click handler
  monthlyBtn?.addEventListener("click", function () {
    if (!this.classList.contains('active')) {
      // Remove active class from yearly button
      yearlyBtn.classList.remove("active");
      // Add active class to monthly button
      this.classList.add("active");

      // Update prices with smooth transition
      animatePriceChange(proPrice, "149");
      animatePriceChange(premiumPrice, "349");

      // Update period text
      pricePeriod.forEach(p => {
        p.style.opacity = '0';
        setTimeout(() => {
          p.innerText = "per month";
          p.style.opacity = '1';
        }, 150);
      });
    }
  });

  // Yearly button click handler
  yearlyBtn?.addEventListener("click", function () {
    if (!this.classList.contains('active')) {
      // Remove active class from monthly button
      monthlyBtn.classList.remove("active");
      // Add active class to yearly button
      this.classList.add("active");

      // Update prices with smooth transition
      animatePriceChange(proPrice, "1490");
      animatePriceChange(premiumPrice, "3490");

      // Update period text
      pricePeriod.forEach(p => {
        p.style.opacity = '0';
        setTimeout(() => {
          p.innerText = "per year";
          p.style.opacity = '1';
        }, 150);
      });
    }
  });

  // Function to animate price changes
  function animatePriceChange(element, newPrice) {
    if (element) {
      element.style.transform = 'scale(1.1)';
      element.style.transition = 'transform 0.2s ease';

      setTimeout(() => {
        element.innerText = newPrice;
        element.style.transform = 'scale(1)';
      }, 100);
    }
  }

  // Testimonials marquee functionality
  initializeTestimonialsMarquee();

  // Contact form functionality
  initializeContactForm();
});

// Testimonials marquee functionality
function initializeTestimonialsMarquee() {
  const marquee = document.querySelector('.testimonials-marquee');
  if (!marquee) return;

  // Add pause on hover functionality
  marquee.addEventListener('mouseenter', function () {
    this.style.animationPlayState = 'paused';
  });

  marquee.addEventListener('mouseleave', function () {
    this.style.animationPlayState = 'running';
  });

  // Add touch pause functionality for mobile
  let isTouching = false;

  marquee.addEventListener('touchstart', function () {
    isTouching = true;
    this.style.animationPlayState = 'paused';
  });

  marquee.addEventListener('touchend', function () {
    isTouching = false;
    setTimeout(() => {
      if (!isTouching) {
        this.style.animationPlayState = 'running';
      }
    }, 1000);
  });

  // Add speed control based on screen size
  function adjustMarqueeSpeed() {
    const width = window.innerWidth;
    let duration = 60; // Default duration in seconds

    if (width <= 400) {
      duration = 30;
    } else if (width <= 576) {
      duration = 35;
    } else if (width <= 768) {
      duration = 45;
    } else {
      duration = 60;
    }

    marquee.style.animationDuration = duration + 's';
  }

  // Adjust speed on window resize
  window.addEventListener('resize', adjustMarqueeSpeed);

  // Initial speed adjustment
  adjustMarqueeSpeed();

  // Add smooth scroll for testimonial section
  function scrollToTestimonials() {
    const testimonialsSection = document.querySelector('.testimonials-section');
    if (testimonialsSection) {
      testimonialsSection.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  }

  // Add click handlers to testimonial cards for better UX
  const testimonialCards = document.querySelectorAll('.testimonial-card');
  testimonialCards.forEach(card => {
    card.addEventListener('click', function () {
      // Add a subtle click effect
      this.style.transform = 'translateY(-15px) scale(1.02)';
      setTimeout(() => {
        this.style.transform = 'translateY(-10px)';
      }, 200);
    });
  });
}

// Contact form functionality
function initializeContactForm() {
  const contactForm = document.querySelector('form[action*="contact"]');
  if (!contactForm) return;

  // Auto-dismiss alerts after 5 seconds
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    setTimeout(() => {
      if (alert && alert.parentNode) {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
          if (alert.parentNode) {
            alert.remove();
          }
        }, 300);
      }
    }, 5000);
  });

  // Smooth scroll to contact form if there are errors or success message
  if (document.querySelector('.alert')) {
    setTimeout(() => {
      const contactSection = document.getElementById('contact');
      if (contactSection) {
        contactSection.scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });
      }
    }, 500);
  }

  // Form submission enhancement
  contactForm.addEventListener('submit', function (e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    // Show loading state
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
    submitBtn.disabled = true;

    // Re-enable button after 3 seconds in case of error
    setTimeout(() => {
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
    }, 3000);
  });

  // Real-time form validation feedback
  const inputs = contactForm.querySelectorAll('input, textarea');
  inputs.forEach(input => {
    input.addEventListener('blur', function () {
      validateField(this);
    });

    input.addEventListener('input', function () {
      if (this.classList.contains('is-invalid')) {
        validateField(this);
      }
    });
  });
}

// Field validation function
function validateField(field) {
  const value = field.value.trim();
  const fieldName = field.name;

  // Remove existing validation classes
  field.classList.remove('is-invalid', 'is-valid');

  // Basic validation rules
  let isValid = true;
  let errorMessage = '';

  switch (fieldName) {
    case 'name':
      if (value.length < 2) {
        isValid = false;
        errorMessage = 'Name must be at least 2 characters long';
      }
      break;

    case 'email':
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(value)) {
        isValid = false;
        errorMessage = 'Please enter a valid email address';
      }
      break;

    case 'subject':
      if (value.length < 5) {
        isValid = false;
        errorMessage = 'Subject must be at least 5 characters long';
      }
      break;

    case 'message':
      if (value.length < 10) {
        isValid = false;
        errorMessage = 'Message must be at least 10 characters long';
      }
      break;
  }

  // Apply validation result
  if (isValid && value.length > 0) {
    field.classList.add('is-valid');
  } else if (!isValid) {
    field.classList.add('is-invalid');

    // Show error message
    let errorDiv = field.parentNode.querySelector('.invalid-feedback');
    if (!errorDiv) {
      errorDiv = document.createElement('div');
      errorDiv.className = 'invalid-feedback';
      field.parentNode.appendChild(errorDiv);
    }
    errorDiv.textContent = errorMessage;
  }
}




