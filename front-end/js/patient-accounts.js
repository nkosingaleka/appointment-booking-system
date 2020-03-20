const verifiedBtn = document.querySelector('#verified-btn');
const unverifiedBtn = document.querySelector('#unverified-btn');
const verifiedSection = document.querySelector('#verified-patients');
const unverifiedSection = document.querySelector('#unverified-patients');

verifiedBtn.addEventListener("click", () => {
    if (verifiedSection.classList.contains("hidden")) {
        verifiedSection.classList.remove("hidden")
    }

    if (!unverifiedSection.classList.contains("hidden")) {
        unverifiedSection.classList.add("hidden")
    }
});

unverifiedBtn.addEventListener("click", () => {
    if (unverifiedSection.classList.contains("hidden")) {
        unverifiedSection.classList.remove("hidden")
    }

    if (!verifiedSection.classList.contains("hidden")) {
        verifiedSection.classList.add("hidden")
    }
});
