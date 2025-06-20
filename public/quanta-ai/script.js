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
});




