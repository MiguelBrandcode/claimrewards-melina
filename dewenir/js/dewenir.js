// 2.0

/*
    Theme Name: Dewenir
    Theme URI: http://dewenir.es

    Author: Dewenir S.L
    Author URI: http://dewenir.es

    Description: Fichero base de customizacion del tema.
    Version: 1.0
*/


(function ($) {
    let saldoTotal = 0;
    let saldoCalculado = 0;

    const formCuponesFunction = {
        init: function () {
            this.calcularSaldo();
            this.config();
            this.eventListeners();
        },
        config: function () {
            this.clicables = $('.clicable');
            this.checkBoxes = $('.seleccionCupon input[type="checkbox"]');
            this.cuponSelects = $('.seleccionCupon .cantidadCupones');
        },
        eventListeners: function () {
            this.clicables.on('click', (event) => {
                const clicable = $(event.currentTarget);
                const checkbox = clicable.children('.checkbox-container').children('.checkbox-tipoCupon');
                const isChecked = checkbox.is(':checked');
                const select = clicable.parent('.seleccionCupon').children('.cantidadCupones');

                if (checkbox.prop('disabled')) {
                    return;
                }

                if (event.target.classList.contains('checkbox-tipoCupon')) {
                    checkbox.prop('checked', isChecked);
                    select.prop('disabled', !isChecked);
                } else {
                    checkbox.prop('checked', !isChecked);
                    select.prop('disabled', isChecked);
                }

                formCuponesFunction.calcularSaldo();
            });

            this.cuponSelects.on('change', (cuponBox) => {
                formCuponesFunction.calcularSaldo();
            });
        },
        calcularSaldo: function () {
            const checkboxes = $('input[type="checkbox"]');
            let total = 0;
            saldoCalculado = saldoTotal;

            checkboxes.each(function () {
                const checkbox = $(this);

                if (!checkbox.is(':checked')) {
                    return;
                }

                const tipoCupon = Number(checkbox.attr('data-tipocupon'));
                const cantidadSeleccionada = Number(checkbox.parent('.checkbox-container').parent('.clicable').siblings().val());

                total = tipoCupon * cantidadSeleccionada;
                saldoCalculado -= total;
            });
            $('.saldo').text(saldoCalculado);

            this.calcularTipoCuponDisponibles();
        },
        calcularTipoCuponDisponibles: function () {
            const checkboxes = $('input[type="checkbox"]').not('.disabled-permanently');

            checkboxes.each(function () {
                const checkbox = $(this);
                const cantidadSeleccionada = Number(checkbox.parent('.checkbox-container').parent('.clicable').siblings().val())

                const tipoCupon = Number(checkbox.attr('data-tipocupon'));
                const total = tipoCupon * cantidadSeleccionada;

                const isDisabled = saldoCalculado == 0 ||
                    saldoCalculado < tipoCupon ||
                    saldoCalculado < total;

                if (cantidadSeleccionada <= 0) {
                    if (isDisabled) {
                        checkbox.prop('checked', false);
                    }
                }

                if (checkbox.is(':checked')) {
                    return;
                }

                checkbox.prop('disabled', isDisabled);

            });

            this.calcularCantidadCuponDisponibles();
        },
        calcularCantidadCuponDisponibles: function () {
            const checkboxes = $('input[type="checkbox"]').not('.disabled-permanently');

            checkboxes.each(function () {
                const checkbox = $(this);
                const tipoCupon = Number(checkbox.attr('data-tipocupon'));
                const optionSelectedValue = Number(checkbox.parent('.checkbox-container').parent('.clicable').siblings().val());
                const options = checkbox.parent('.checkbox-container').parent('.clicable').siblings().children();

                let saldoCalculadoRefre = saldoCalculado;
                saldoCalculadoRefre += tipoCupon * optionSelectedValue;

                options.each(function () {
                    const option = $(this);
                    const cantidad = Number(option.val());
                    const total = tipoCupon * cantidad;

                    let isDisabled = saldoCalculadoRefre == 0 || saldoCalculadoRefre < total;
                    if (cantidad <= optionSelectedValue) {
                        isDisabled = false;
                    }

                    option.prop('disabled', isDisabled);
                });
            });

            this.anadirAlCarrito();
        },
        anadirAlCarrito: function () {
            let productos = [];
            let total = 0;

            const checkboxes = $('input[type="checkbox"]:checked');

            checkboxes.each(function () {
                const checkbox = $(this);
                const tipoCupon = Number(checkbox.attr('data-tipocupon'));
                const cantidadSeleccionada = Number(checkbox.parent('.checkbox-container').parent('.clicable').siblings().val());

                total += tipoCupon * cantidadSeleccionada;

                const containerCupon = checkbox.closest('.container-cupon').get(0);
                const nombreProducto = containerCupon.querySelector('.grupoCupon').textContent;

                const producto = {
                    grupoCupon: tipoCupon,
                    cantidad: cantidadSeleccionada,
                    nomProducto: nombreProducto,
                };

                productos.push(producto);
            });
            $('#totalPrecio').text(total);

            const domProductos = $('.productos');
            const domUnidades = $('.unidades');
            domProductos.html('');
            domUnidades.html('');

            let currency = $('.currency-simbol').text();

            $.each(productos, function () {
                const producto = this;

                if (producto.cantidad == 0) return;

                const productoCarrito = $('<div/>', {
                    'html': `${producto.nomProducto} ${producto.grupoCupon}${currency}`,
                    'class': 'producto-carrito',
                });
                domProductos.append(productoCarrito);

                const udsCarrito = $('<div/>', {
                    'html': `${producto.cantidad}`,
                    'class': 'uds-carrito',
                });
                domUnidades.append(udsCarrito);
            });
        },
    };

    const canjearCupones = {
        init: function () {
            this.config();
            this.eventListeners();
        },
        config: function () {
            this.btnCanjear = $('#enviarBoton');
            this.modal = $('#myModal');
            this.continuar = this.modal.find('.continuar');
            this.canjear = this.modal.find('.canjear');
            this.formularioCupones = $('#formularioCupones');
        },
        eventListeners: function () {
            this.btnCanjear.on('click', () => {
                if (!(saldoCalculado < saldoTotal)) {
                    return;
                }
                if (saldoCalculado > 0) {
                    this.modal.css({
                        visibility: 'visible',
                        opacity: '1',
                    });
                    // $('body').css({
                    //     overflow: 'hidden'
                    // });
                    return;
                } else {
                    $('#formularioCupones').submit();
                }
            });

            this.continuar.on('click', () => {
                this.modal.css({
                    visibility: 'hidden',
                    opacity: '0',
                });
                // $('body').css({
                //     overflow: 'visible'
                // });
            });

            this.canjear.on('click', () => {
                $('#formularioCupones').submit();
            });
        },
        exec: function () { },
    };

    const ocultarModalError = {
        init: function () {
            this.config();
            this.eventListeners();
        },
        config: function () {
            this.modal = $('#errorModal');
            this.aceptar = this.modal.find('.aceptar');
        },
        eventListeners: function () {
            this.aceptar.on('click', () => {
                this.modal.css({
                    'visibility': 'hidden',
                    'opacity': '0',
                });
                return;
            });
        },
    };

    const copyToClipboard = {
        init: function () {
            this.eventListeners();
        },
        eventListeners: function () {
            $('.btn-copiar').on('click', (buttonClicked) => {
                const copyText = $(buttonClicked.delegateTarget).siblings('.cupon-codigo-texto').text();
                navigator.clipboard.writeText(copyText);
            });
        },
    };

    const reCAPTCHA = {
        init: function () {
            this.eventListeners();
        },
        eventListeners: function () {
            grecaptcha.ready(function () {
                grecaptcha.execute('6LcDFZEqAAAAAKg83QIfphiKjBp7BngPA0zQI3LS', { //Clave sitio web
                    action: 'submit'
                })
                    .then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                    });
            });
        }
    };

    const select2 = {
        init: function () {
            this.config();
            this.eventListeners();
        },
        config: function () {
            this.selects = $('.cantidadCupones')
        },
        eventListeners: function () {
            this.selects.select2();
        }
    };

    const positionFixed = {
        init: function () {
            this.config();
            this.eventListeners();
        },
        config: function () {
            this.containerCarrito = $('.container-carrito');
        },
        eventListeners: function () {
            const self = this;
            $(window).scroll(function () {
                const scroll = $(window).scrollTop();
                const documentHeight = $(document).height();
                const documentWidth = $(document).width();
                const windowHeight = $(window).height();
                const totalScrollable = documentHeight - windowHeight;
                const scrollPercent = (scroll / totalScrollable) * 100;

                if (documentHeight <= 1400 || documentWidth <= 894) {
                    return;
                }

                const containerHeight = self.containerCarrito.outerHeight();
                const centerPosition = (windowHeight - containerHeight - 100) / 2;

                if (scroll >= 100 && scrollPercent < 85) {
                    self.containerCarrito.css({
                        top: `${centerPosition}px`,
                        transform: `translate(0, ${scroll - 100}px)`,
                    });
                } else if (scrollPercent >= 85) {
                    self.containerCarrito.css({
                        top: `${centerPosition}px`,
                    });
                } else {
                    self.containerCarrito.css({
                        top: '',
                        transform: 'unset',
                    });
                }
            });
        },
    };

    $(document).ready(function () {
        if ($('body').hasClass('form-ingresa-tu-codigo')) {
            reCAPTCHA.init();
        }

        if ($('body').hasClass('form-cupones')) {
            saldoTotal = Number($('.saldo').get(0).innerHTML);

            formCuponesFunction.init();
            canjearCupones.init();
            ocultarModalError.init();
            select2.init();
            positionFixed.init();
        }

        if ($('body').hasClass('canjeado-exitosamente')) {

            const btnCanjearOtro = $('#btnCanjearOtro');

            btnCanjearOtro.on('click', () => {
                const hostname = window.location.hostname;

                // Leer cookie WPML de forma robusta
                let wpml_idioma = 'en';
                const rawCookie = document.cookie.split('; ');

                rawCookie.forEach(c => {
                    if (c.includes('wp-wpml_current_language')) {
                        wpml_idioma = c.split('=')[1].trim().toLowerCase();
                    }
                });

                // Redirección directa (sin mapa, si usan el mismo valor)
                const redirectUrl = `https://${hostname}/${wpml_idioma}/`;
                window.location.href = redirectUrl;
            });

            copyToClipboard.init();
        }

    });
})(jQuery);
