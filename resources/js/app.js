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

    // 3. Price calculator by Zone selection & sync with contact form
    const zoneSelect = document.getElementById('zone-select');
    const formZonaSelect = document.getElementById('form-zona');
    const priceCards = document.querySelectorAll('.price-card');

    const updatePrices = () => {
        if (!zoneSelect || priceCards.length === 0) return;

        const selectedOption = zoneSelect.options[zoneSelect.selectedIndex];
        const surcharge = parseFloat(selectedOption?.dataset?.recargo || 0);
        const isConsult = selectedOption?.dataset?.consultar === '1';

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

    if (zoneSelect && priceCards.length > 0) {
        zoneSelect.addEventListener('change', () => {
            updatePrices();
            if (formZonaSelect) {
                formZonaSelect.value = zoneSelect.value;
                recalculatePresupuesto();
            }
        });
        updatePrices();
    }

    if (formZonaSelect && zoneSelect) {
        formZonaSelect.addEventListener('change', () => {
            zoneSelect.value = formZonaSelect.value;
            updatePrices();
            recalculatePresupuesto();
        });
    }

    // 4. "Reservar" button click -> autofill form and scroll
    const reserveBtns = document.querySelectorAll('.btn-reservar');
    const formHorasInput = document.getElementById('form-horas');
    const formMensajeInput = document.getElementById('form-mensaje');

    reserveBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const tarifaNombre = btn.dataset.tarifaNombre || '';
            const selectedZoneText = zoneSelect ? zoneSelect.options[zoneSelect.selectedIndex]?.text : '';

            if (formHorasInput) {
                let matched = false;
                for (let i = 0; i < formHorasInput.options.length; i++) {
                    const opt = formHorasInput.options[i];
                    if (opt.text.toLowerCase().includes(tarifaNombre.toLowerCase()) ||
                        opt.dataset.nombre?.toLowerCase().includes(tarifaNombre.toLowerCase())) {
                        formHorasInput.selectedIndex = i;
                        matched = true;
                        break;
                    }
                }
                if (!matched) {
                    const matchHours = tarifaNombre.match(/\d+/);
                    if (matchHours) {
                        formHorasInput.value = matchHours[0];
                    }
                }
            }

            if (formZonaSelect && zoneSelect) {
                formZonaSelect.value = zoneSelect.value;
            }

            if (formMensajeInput) {
                formMensajeInput.value = `Hola, quiero información y reservar la opción de ${tarifaNombre} para mi evento en la zona de ${selectedZoneText}.`;
            }

            recalculatePresupuesto();

            const contactoSection = document.getElementById('contacto');
            if (contactoSection) {
                contactoSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // 4.1 Presupuesto en vivo (Live Calculation via AJAX)
    const formHoras = document.getElementById('form-horas');
    const formHorasExtraViaje = document.getElementById('form-horas-extra-viaje');
    const formNocturnidad = document.getElementById('form-nocturnidad');
    const extraCheckboxes = document.querySelectorAll('.extra-checkbox');
    const desgloseLinesContainer = document.getElementById('presupuesto-desglose-lines');
    const totalDisplay = document.getElementById('presupuesto-total-display');
    const totalNote = document.getElementById('presupuesto-total-note');
    const csrfToken = document.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    async function recalculatePresupuesto() {
        if (!desgloseLinesContainer || !totalDisplay) return;

        const horas = formHoras ? formHoras.value : 2;
        const zona = formZonaSelect ? formZonaSelect.value : (zoneSelect ? zoneSelect.value : 'Zona A');
        const horasExtraViaje = formHorasExtraViaje ? parseInt(formHorasExtraViaje.value || 0, 10) : 0;
        const nocturnidad = formNocturnidad ? formNocturnidad.checked : false;

        const extras = [];
        extraCheckboxes.forEach(cb => {
            if (cb.checked) {
                extras.push(cb.value);
            }
        });

        try {
            const response = await fetch('/presupuesto/calcular', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    horas,
                    zona,
                    horas_extra_viaje: horasExtraViaje,
                    nocturnidad,
                    extras,
                }),
            });

            if (!response.ok) return;

            const data = await response.json();

            // Render line items
            let linesHtml = '';

            // 1. Tarifa servicio
            const tarifa = data.tarifa || {};
            linesHtml += `
                <div class="flex justify-between items-center py-1 border-b border-white/5">
                    <span class="text-gray-300">Servicio Cabina 360 (${tarifa.nombre || horas + ' horas'}):</span>
                    <span class="font-bold text-white">${parseFloat(tarifa.subtotal || 0).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</span>
                </div>
            `;

            // 2. Desplazamiento
            const zonaInfo = data.zona;
            const recargoZona = parseFloat(data.recargo_zona || 0);
            const aConsultar = data.a_consultar;

            let recargoText = '0,00 € (Incluido)';
            if (aConsultar) {
                recargoText = '<span class="text-[var(--color-azul-claro)] font-bold">A consultar</span>';
            } else if (recargoZona > 0) {
                recargoText = '+' + recargoZona.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
            }

            linesHtml += `
                <div class="flex justify-between items-center py-1 border-b border-white/5">
                    <span class="text-gray-300">Desplazamiento (${zonaInfo ? zonaInfo.nombre : zona}):</span>
                    <span class="font-bold ${aConsultar ? 'text-[var(--color-azul-claro)]' : (recargoZona > 0 ? 'text-white' : 'text-emerald-400')}">${recargoText}</span>
                </div>
            `;

            // 3. Horas extra viaje
            const extraViaje = data.horas_extra_viaje || {};
            if (extraViaje.horas > 0) {
                linesHtml += `
                    <div class="flex justify-between items-center py-1 border-b border-white/5">
                        <span class="text-gray-300">+${extraViaje.horas} h extra de viaje / espera:</span>
                        <span class="font-bold text-white">+${parseFloat(extraViaje.subtotal || 0).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</span>
                    </div>
                `;
            }

            // 4. Extras
            if (Array.isArray(data.extras) && data.extras.length > 0) {
                data.extras.forEach(extra => {
                    linesHtml += `
                        <div class="flex justify-between items-center py-1 border-b border-white/5">
                            <span class="text-gray-300">Extra: ${extra.nombre}:</span>
                            <span class="font-bold text-[var(--color-dorado)]">+${parseFloat(extra.precio || 0).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</span>
                        </div>
                    `;
                });
            }

            // 5. Nocturnidad
            const nocturnidadData = data.nocturnidad || {};
            if (nocturnidadData.aplica) {
                linesHtml += `
                    <div class="flex justify-between items-center py-1 border-b border-white/5">
                        <span class="text-gray-300">Recargo horario nocturno:</span>
                        <span class="font-bold text-white">+${parseFloat(nocturnidadData.importe || 0).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} €</span>
                    </div>
                `;
            }

            desgloseLinesContainer.innerHTML = linesHtml;

            // Update Total
            const total = parseFloat(data.total || 0);
            if (aConsultar) {
                totalDisplay.textContent = total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €*';
                if (totalNote) totalNote.textContent = '* Desplazamiento a consultar según kilometraje';
            } else {
                totalDisplay.textContent = total.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' €';
                if (totalNote) totalNote.textContent = 'Todo incluido · Sin gastos ocultos';
            }
        } catch (err) {
            console.error('Error calculando presupuesto:', err);
        }
    }

    if (formHoras) formHoras.addEventListener('change', recalculatePresupuesto);
    if (formHorasExtraViaje) formHorasExtraViaje.addEventListener('change', recalculatePresupuesto);
    if (formNocturnidad) formNocturnidad.addEventListener('change', recalculatePresupuesto);
    extraCheckboxes.forEach(cb => cb.addEventListener('change', recalculatePresupuesto));

    if (desgloseLinesContainer) {
        recalculatePresupuesto();
    }

    // 4.2 Botón «Descargar Presupuesto en PDF»
    const btnDescargarPdf = document.getElementById('btn-descargar-pdf');
    const alertMessage = document.getElementById('pdf-alert-message');
    const formNombre = document.getElementById('form-nombre');
    const formTelefono = document.getElementById('form-telefono');
    const formEmail = document.getElementById('form-email');
    const formCiudad = document.getElementById('form-ciudad');
    const formFecha = document.getElementById('form-fecha');
    const formTipo = document.getElementById('form-tipo');
    const formMensaje = document.getElementById('form-mensaje');
    const consentimiento = document.getElementById('consentimiento');

    if (btnDescargarPdf) {
        btnDescargarPdf.addEventListener('click', async (e) => {
            e.preventDefault();

            if (alertMessage) {
                alertMessage.classList.add('hidden');
                alertMessage.className = 'hidden mb-6 p-4 rounded-2xl text-sm font-medium';
            }

            // Validate minimum required fields
            const missing = [];
            if (!formNombre || !formNombre.value.trim()) missing.push({ el: formNombre, label: 'Nombre completo' });
            if (!formTelefono || !formTelefono.value.trim()) missing.push({ el: formTelefono, label: 'Teléfono' });
            if (!formEmail || !formEmail.value.trim() || !formEmail.value.includes('@')) missing.push({ el: formEmail, label: 'Correo electrónico válido' });
            if (!formCiudad || !formCiudad.value.trim()) missing.push({ el: formCiudad, label: 'Ciudad / Población' });
            if (consentimiento && !consentimiento.checked) missing.push({ el: consentimiento, label: 'Aceptar la política de privacidad' });

            if (missing.length > 0) {
                if (alertMessage) {
                    alertMessage.textContent = 'Por favor, completa los campos requeridos para expedir tu presupuesto: ' + missing.map(m => m.label).join(', ') + '.';
                    alertMessage.classList.remove('hidden');
                    alertMessage.classList.add('bg-amber-500/20', 'border', 'border-amber-500/40', 'text-amber-300');
                    alertMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                if (missing[0].el) {
                    missing[0].el.focus();
                }
                return;
            }

            const originalHtml = btnDescargarPdf.innerHTML;
            btnDescargarPdf.disabled = true;
            btnDescargarPdf.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-black inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Generando tu presupuesto PDF...</span>
            `;

            const selectedExtras = [];
            extraCheckboxes.forEach(cb => {
                if (cb.checked) selectedExtras.push(cb.value);
            });

            const payload = {
                nombre: formNombre.value.trim(),
                telefono: formTelefono.value.trim(),
                email: formEmail.value.trim(),
                ciudad: formCiudad.value.trim(),
                fecha_evento: formFecha ? formFecha.value : null,
                tipo_evento: formTipo ? formTipo.value : 'Boda',
                horas: formHoras ? formHoras.value : 2,
                zona: formZonaSelect ? formZonaSelect.value : (zoneSelect ? zoneSelect.value : 'Zona A'),
                horas_extra_viaje: formHorasExtraViaje ? parseInt(formHorasExtraViaje.value || 0, 10) : 0,
                nocturnidad: formNocturnidad ? formNocturnidad.checked : false,
                extras: selectedExtras,
                mensaje: formMensaje ? formMensaje.value.trim() : '',
                consentimiento: consentimiento && consentimiento.checked ? 1 : null,
            };

            try {
                const response = await fetch('/presupuesto', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (response.ok && data.pdf_url) {
                    if (alertMessage) {
                        alertMessage.innerHTML = `
                            🎉 <strong>¡Presupuesto ${data.numero} generado con éxito!</strong><br>
                            Hemos enviado una copia a <strong>${payload.email}</strong> y la descarga de tu PDF ha comenzado.
                            <br><a href="${data.pdf_url}" target="_blank" class="underline font-bold text-white mt-1 inline-block">Si la descarga no empieza automáticamente, haz clic aquí.</a>
                        `;
                        alertMessage.classList.remove('hidden');
                        alertMessage.classList.add('bg-emerald-500/20', 'border', 'border-emerald-500/40', 'text-emerald-300');
                    }

                    window.location.href = data.pdf_url;
                } else {
                    const errorMsg = data.message || (data.errors ? Object.values(data.errors).flat().join('<br>') : 'Ha ocurrido un error al generar el presupuesto.');
                    if (alertMessage) {
                        alertMessage.innerHTML = '⚠️ ' + errorMsg;
                        alertMessage.classList.remove('hidden');
                        alertMessage.classList.add('bg-red-500/20', 'border', 'border-red-500/40', 'text-red-300');
                    }
                }
            } catch (err) {
                console.error('Error generando presupuesto:', err);
                if (alertMessage) {
                    alertMessage.textContent = 'Error de conexión al generar el presupuesto. Por favor, inténtalo de nuevo o escríbenos por WhatsApp.';
                    alertMessage.classList.remove('hidden');
                    alertMessage.classList.add('bg-red-500/20', 'border', 'border-red-500/40', 'text-red-300');
                }
            } finally {
                btnDescargarPdf.disabled = false;
                btnDescargarPdf.innerHTML = originalHtml;
            }
        });
    }

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
    // 8. Comprobación en vivo de disponibilidad
    const formHoraInput = document.getElementById('form-hora');
    const formFechaInput = document.getElementById('form-fecha');
    const btnEnviarReserva = document.getElementById('btn-enviar-reserva');
    
    async function checkDisponibilidad() {
        if (!formFechaInput || !formHoraInput || !formHoras) return;
        
        const fecha = formFechaInput.value;
        const hora = formHoraInput.value;
        const horas = formHoras.value || 2;
        
        if (!fecha || !hora) return;
        
        // Disable button while checking
        if (btnEnviarReserva) btnEnviarReserva.disabled = true;
        
        try {
            const url = new URL(window.location.origin + '/disponibilidad');
            url.searchParams.append('fecha', fecha);
            url.searchParams.append('hora_inicio', hora);
            url.searchParams.append('horas', horas);
            
            const response = await fetch(url.toString(), {
                headers: { 'Accept': 'application/json' }
            });
            
            if (!response.ok) {
                if (btnEnviarReserva) btnEnviarReserva.disabled = false;
                return;
            }
            
            const data = await response.json();
            
            if (alertMessage) {
                alertMessage.classList.remove('hidden');
                if (data.libre) {
                    alertMessage.innerHTML = '✅ <strong>¡Fecha disponible!</strong> Puedes continuar con la reserva.';
                    alertMessage.className = 'mb-6 p-4 rounded-2xl text-sm font-medium bg-emerald-500/20 border border-emerald-500/40 text-emerald-300';
                    if (btnEnviarReserva) btnEnviarReserva.disabled = false;
                } else {
                    let altHtml = '❌ <strong>Esa fecha/hora ya está ocupada.</strong><br>';
                    if (data.alternativas && data.alternativas.length > 0) {
                        altHtml += 'Fechas alternativas cercanas libres: <ul>';
                        data.alternativas.forEach(alt => {
                            altHtml += `<li>- ${alt}</li>`;
                        });
                        altHtml += '</ul>';
                    } else {
                        altHtml += 'No hemos encontrado alternativas cercanas. Por favor prueba otra fecha.';
                    }
                    alertMessage.innerHTML = altHtml;
                    alertMessage.className = 'mb-6 p-4 rounded-2xl text-sm font-medium bg-red-500/20 border border-red-500/40 text-red-300';
                }
            }
        } catch (e) {
            console.error('Error fetching disponibilidad', e);
            if (btnEnviarReserva) btnEnviarReserva.disabled = false;
        }
    }
    
    if (formFechaInput) formFechaInput.addEventListener('change', checkDisponibilidad);
    if (formHoraInput) formHoraInput.addEventListener('change', checkDisponibilidad);
    if (formHoras) formHoras.addEventListener('change', checkDisponibilidad);

});
