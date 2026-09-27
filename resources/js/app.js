document.addEventListener('DOMContentLoaded', () => {
    // 1. Header scroll effect
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // 2. Mobile Nav Toggle
    const navToggleBtn = document.getElementById('nav-toggle-btn');
    const navMenu = document.getElementById('nav-menu');
    if (navToggleBtn && navMenu) {
        navToggleBtn.addEventListener('click', () => {
            navMenu.classList.toggle('hidden');
        });
    }

    // 3. Price calculator by Zone selection
    const zoneSelect = document.getElementById('zone-select');
    const priceCards = document.querySelectorAll('.price-card');

    if (zoneSelect && priceCards.length > 0) {
        const updatePrices = () => {
            const selectedOption = zoneSelect.options[zoneSelect.selectedIndex];
            const surcharge = parseFloat(selectedOption.dataset.recargo || 0);
            const isConsult = selectedOption.dataset.consultar === '1';

            priceCards.forEach(card => {
                const basePrice = parseFloat(card.dataset.basePrice || 0);
                const priceDisplay = card.querySelector('.price-value') || card.querySelector('.price-display');
                const surchargeDisplay = card.querySelector('.surcharge-display');

                if (priceDisplay) {
                    if (isConsult) {
                        priceDisplay.textContent = 'Consultar';
                        if (surchargeDisplay) surchargeDisplay.textContent = 'Recargo a consultar según km';
                    } else if (isNaN(basePrice) || basePrice === 0) {
                        priceDisplay.textContent = 'Consultar';
                        if (surchargeDisplay) surchargeDisplay.textContent = '';
                    } else {
                        const total = basePrice + surcharge;
                        priceDisplay.textContent = total + ' €';
                        if (surchargeDisplay) {
                            if (surcharge > 0) {
                                surchargeDisplay.textContent = `(${basePrice} € base + ${surcharge} € desplazamiento)`;
                            } else {
                                surchargeDisplay.textContent = 'Sin recargo de desplazamiento';
                            }
                        }
                    }
                }
            });
        };

        zoneSelect.addEventListener('change', updatePrices);
        updatePrices();
    }

    // 4. "Reservar" button click -> autofill form and scroll
    const reserveBtns = document.querySelectorAll('.btn-reservar');
    const formHorasInput = document.getElementById('form-horas');
    const formZonaInput = document.getElementById('form-zona');
    const formMensajeInput = document.getElementById('form-mensaje');

    reserveBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const tarifaNombre = btn.dataset.tarifaNombre || '';
            const selectedZoneText = zoneSelect ? zoneSelect.options[zoneSelect.selectedIndex].text : '';

            if (formHorasInput) formHorasInput.value = tarifaNombre;
            if (formZonaInput && zoneSelect) formZonaInput.value = zoneSelect.value;
            if (formMensajeInput) {
                formMensajeInput.value = `Hola, quiero información y reservar la opción de ${tarifaNombre} para mi evento en la zona de ${selectedZoneText}.`;
            }

            const contactoSection = document.getElementById('contacto');
            if (contactoSection) {
                contactoSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // 5. FAQ Accordions
    const accordionHeaders = document.querySelectorAll('.faq-accordion-header');
    accordionHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const item = header.parentElement;
            const isActive = item.classList.contains('active');

            document.querySelectorAll('.faq-accordion-item').forEach(el => el.classList.remove('active'));

            if (!isActive) {
                item.classList.add('active');
            }
        });
    });

    // 6. Video Lightbox Modal
    const videoLightbox = document.getElementById('video-lightbox');
    const videoLightboxIframe = document.getElementById('video-lightbox-iframe');
    const videoLightboxVideo = document.getElementById('video-lightbox-video');
    const closeLightboxBtn = document.getElementById('close-lightbox');
    const videoTriggers = document.querySelectorAll('.video-trigger');

    if (videoLightbox && closeLightboxBtn) {
        const closeLightbox = () => {
            videoLightbox.classList.remove('open');
            if (videoLightboxIframe) {
                videoLightboxIframe.src = '';
                videoLightboxIframe.classList.add('hidden');
            }
            if (videoLightboxVideo) {
                videoLightboxVideo.pause();
                videoLightboxVideo.src = '';
                videoLightboxVideo.classList.add('hidden');
            }
        };

        videoTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const videoUrl = trigger.dataset.videoUrl;

                if (!videoUrl) return;

                videoLightbox.classList.add('open');

                if (videoUrl.includes('youtube.com') || videoUrl.includes('vimeo.com') || videoUrl.includes('youtu.be')) {
                    let embedUrl = videoUrl;
                    if (videoUrl.includes('youtube.com/watch?v=')) {
                        embedUrl = videoUrl.replace('watch?v=', 'embed/');
                    } else if (videoUrl.includes('youtu.be/')) {
                        embedUrl = videoUrl.replace('youtu.be/', 'youtube.com/embed/');
                    }
                    if (videoLightboxIframe) {
                        videoLightboxIframe.src = embedUrl;
                        videoLightboxIframe.classList.remove('hidden');
                    }
                } else {
                    if (videoLightboxVideo) {
                        videoLightboxVideo.src = videoUrl;
                        videoLightboxVideo.classList.remove('hidden');
                        videoLightboxVideo.play();
                    }
                }
            });
        });

        closeLightboxBtn.addEventListener('click', closeLightbox);
        videoLightbox.addEventListener('click', (e) => {
            if (e.target === videoLightbox) closeLightbox();
        });
    }

    // 7. Intersection Observer for Scroll Animations
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    if ('IntersectionObserver' in window && animatedElements.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        animatedElements.forEach(el => observer.observe(el));
    } else {
        animatedElements.forEach(el => el.classList.add('visible'));
    }
});
