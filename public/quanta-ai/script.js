AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    

// pricing

  const monthlyBtn = document.getElementById("monthlyBtn");
  const yearlyBtn = document.getElementById("yearlyBtn");

  const proPrice = document.getElementById("proPrice");
  const premiumPrice = document.getElementById("premiumPrice");
  const pricePeriod = document.querySelectorAll(".price-period");

  // Set initial state to monthly
  if (monthlyBtn) {
    monthlyBtn.classList.add("active");
  }

  monthlyBtn?.addEventListener("click", () => {
    monthlyBtn.classList.add("active");
    yearlyBtn.classList.remove("active");

    proPrice.innerText = "149";
    premiumPrice.innerText = "349";
    pricePeriod.forEach(p => p.innerText = "per month");
  });

  yearlyBtn?.addEventListener("click", () => {
    yearlyBtn.classList.add("active");
    monthlyBtn.classList.remove("active");

    proPrice.innerText = "1490";
    premiumPrice.innerText = "3490";
    pricePeriod.forEach(p => p.innerText = "per year");
  });




