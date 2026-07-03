// index.js - PowerZone.lk Modern Interactivity Engine

document.addEventListener("DOMContentLoaded", function () {
    // ==========================================
    // 1. Live Clock & Dynamic Present Time Greeting
    // ==========================================
    const liveClockEl = document.getElementById("live-clock");
    const greetingEl = document.getElementById("time-greeting");

    function updateTimeAndGreeting() {
        const now = new Date();
        
        // Update Live Clock Display
        if (liveClockEl) {
            let hours = now.getHours();
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            const hoursStr = String(hours).padStart(2, '0');
            liveClockEl.innerText = `${hoursStr}:${minutes}:${seconds} ${ampm}`;
        }

        // Update Time-of-Day Greeting and Dynamic Styles
        if (greetingEl) {
            const currentHour = now.getHours();
            let greeting = "";
            let timeClass = "";

            if (currentHour >= 5 && currentHour < 12) {
                greeting = "Good morning! Powering your day.";
                timeClass = "morning-theme";
            } else if (currentHour >= 12 && currentHour < 17) {
                greeting = "Good afternoon! Find the best gadgets.";
                timeClass = "afternoon-theme";
            } else if (currentHour >= 17 && currentHour < 21) {
                greeting = "Good evening! Welcome to PowerZone.";
                timeClass = "evening-theme";
            } else {
                greeting = "Good night! Safe tech solutions for your home.";
                timeClass = "night-theme";
            }

            greetingEl.innerText = greeting;
            
            // Apply time-specific classes to top navbar for matching theme styles
            const topNavbar = document.querySelector(".top-navbar");
            if (topNavbar) {
                topNavbar.className = "top-navbar " + timeClass;
            }
        }
    }

    // Run clock updates
    updateTimeAndGreeting();
    setInterval(updateTimeAndGreeting, 1000);


    // ==========================================
    // 2. Dark / Light Mode Switcher
    // ==========================================
    const themeToggleBtn = document.getElementById("theme-toggle-btn");
    const htmlEl = document.documentElement;

    // Load theme setting from localStorage
    const savedTheme = localStorage.getItem("theme") || "light";
    htmlEl.setAttribute("data-theme", savedTheme);
    updateToggleIcon(savedTheme);

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener("click", function () {
            const currentTheme = htmlEl.getAttribute("data-theme");
            const newTheme = currentTheme === "dark" ? "light" : "dark";
            
            htmlEl.setAttribute("data-theme", newTheme);
            localStorage.setItem("theme", newTheme);
            updateToggleIcon(newTheme);
            
            // Add click vibration effect
            themeToggleBtn.classList.add("click-anim");
            setTimeout(() => themeToggleBtn.classList.remove("click-anim"), 200);
        });
    }

    function updateToggleIcon(theme) {
        if (!themeToggleBtn) return;
        const icon = themeToggleBtn.querySelector("i");
        if (icon) {
            if (theme === "dark") {
                icon.className = "fa-solid fa-sun";
            } else {
                icon.className = "fa-solid fa-moon";
            }
        }
    }


    // ==========================================
    // 3. Interactive Tech Time Machine
    // ==========================================
    const timelineButtons = document.querySelectorAll(".btn-timeline");
    const thenImg = document.getElementById("time-machine-then-img");
    const thenTitle = document.getElementById("time-machine-then-title");
    const thenDesc = document.getElementById("time-machine-then-desc");
    
    const nowImg = document.getElementById("time-machine-now-img");
    const nowTitle = document.getElementById("time-machine-now-title");
    const nowDesc = document.getElementById("time-machine-now-desc");

    // Era Data Configurations
    const eraData = {
        "1980": {
            then: {
                title: "CRT Television",
                desc: "Bulky, wood grain chassis with physical manual dial tuning, cathode-ray technology, and heavy static interference.",
                img: "https://images.unsplash.com/photo-1595935736128-db120a2797d7?w=500&auto=format&fit=crop&q=60"
            },
            now: {
                title: "40″ Slim LED TV",
                desc: "Paper-thin display, smart application streaming, multiple HDMI/USB interfaces, and crystal clear Full HD visuals.",
                img: "image/consumer electronic/tv.webp"
            }
        },
        "1990": {
            then: {
                title: "Cassette Walkman",
                desc: "Analog cassette tape audio playback with physical plastic rewind/fast-forward keys, powered by AA batteries, with wire foam-pad headsets.",
                img: "https://images.unsplash.com/photo-1544923246-77307dd654cb?w=500&auto=format&fit=crop&q=60"
            },
            now: {
                title: "Sony 5.1 Surround Setup",
                desc: "High-power multi-channel home theater cinematic audio, deep active subwoofer bass, and digital Bluetooth stream integration.",
                img: "image/consumer electronic/home theater.webp"
            }
        },
        "2000": {
            then: {
                title: "Nokia 3310 Mobile",
                desc: "Monochrome LCD screen, physical number keypad, thick plastic shell casing, basic SMS communications, and retro Snake II gaming.",
                img: "https://images.unsplash.com/photo-1523206489230-c012c64b2b48?w=500&auto=format&fit=crop&q=60"
            },
            now: {
                title: "Mibro GS SmartWatch",
                desc: "AMOLED full-color touch panel, active heart rate and SpO2 tracking sensors, smart message pushes, and 14-day battery backups.",
                img: "image/consumer electronic/smart watch.jpg"
            }
        },
        "2010": {
            then: {
                title: "Bulky DSLR Camera",
                desc: "Heavy DSLR body chassis, complex optical viewfinders, manual focus rings, and slow wired file extractions.",
                img: "https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&auto=format&fit=crop&q=60"
            },
            now: {
                title: "GoPro Action Camera",
                desc: "Ultra-compact 4K videography at 30fps, 16MP photos, IP68 waterproofing up to 30 meters, and instant mobile Wi-Fi sharing.",
                img: "image/consumer electronic/gopro.jpg"
            }
        },
        "2026": {
            then: {
                title: "Manual Spin Mop",
                desc: "Legacy bucket with plastic manual spin-wringing mechanism, requiring heavy manual sweeping, water changes, and hard scrubbing.",
                img: "image/household appliance/mop.jpg"
            },
            now: {
                title: "AMD Ryzen 5 Laptop",
                desc: "6-core Ryzen processor, 8GB DDR4 memory modules, ultra-fast SSD storage units, and Windows 11 modern interface panels.",
                img: "image/consumer electronic/laptop.webp"
            }
        }
    };

    if (timelineButtons.length > 0) {
        timelineButtons.forEach(button => {
            button.addEventListener("click", function () {
                // Remove active classes
                timelineButtons.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                const era = this.getAttribute("data-era");
                const data = eraData[era];

                if (data) {
                    // Apply fade-out class to comparison panel
                    const displayCard = document.querySelector(".time-machine-display");
                    if (displayCard) {
                        displayCard.style.opacity = "0.3";
                        displayCard.style.transform = "scale(0.98)";
                        
                        setTimeout(() => {
                            // Update content
                            if (thenImg) thenImg.src = data.then.img;
                            if (thenTitle) thenTitle.innerText = data.then.title;
                            if (thenDesc) thenDesc.innerText = data.then.desc;

                            if (nowImg) nowImg.src = data.now.img;
                            if (nowTitle) nowTitle.innerText = data.now.title;
                            if (nowDesc) nowDesc.innerText = data.now.desc;

                            // Fade back in
                            displayCard.style.opacity = "1";
                            displayCard.style.transform = "scale(1)";
                        }, 250);
                    }
                }
            });
        });
    }

    // ==========================================
    // 4. Legacy Star Rating & Reviews Form Handles (Compatibility)
    // ==========================================
    // (Used as dynamic frontend fallbacks for client side)
    window.submitReview = function(event) {
        // Form review handler fallback
        // If form has no method or action, it runs this client-side fallback
        const nameInput = document.getElementById('reviewer-name');
        const commentInput = document.getElementById('reviewer-comment');
        if (!nameInput || !commentInput) return;

        const name = nameInput.value;
        const comment = commentInput.value;

        const reviewSection = document.getElementById('customer-reviews');
        if (reviewSection) {
            const noReviews = reviewSection.querySelector(".no-reviews-fallback");
            if (noReviews) noReviews.remove();

            const reviewItem = document.createElement('div');
            reviewItem.className = 'review-card';
            reviewItem.innerHTML = `
                <div class="review-header d-flex justify-content-between mb-2">
                    <h5 class="reviewer-name m-0"><i class="fa-solid fa-circle-user text-secondary me-2"></i>${name}</h5>
                    <div class="reviewer-stars text-warning">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                </div>
                <p class="reviewer-comment m-0 text-muted">${comment}</p>
            `;
            reviewSection.appendChild(reviewItem);
        }

        const form = document.getElementById('review-form');
        if (form && !form.getAttribute('action')) {
            event.preventDefault();
            form.reset();
        }
    };
});