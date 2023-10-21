/*!

 =========================================================
 * Bootstrap Wizard - v1.1.1
 =========================================================
 
 * Product Page: https://www.creative-tim.com/product/bootstrap-wizard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/bootstrap-wizard/blob/master/LICENSE.md)
 
 =========================================================
 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */

// Get Shit Done Kit Bootstrap Wizard Functions

searchVisible = 0;
transparent = true;

$(document).ready(function(){

    /*  Activate the tooltips      */
    $('[rel="tooltip"]').tooltip();

    // Code for the Validator
    var $validator = $('.wizard-card form').validate({
		  rules: {
		    txtListTipo: {
		      required: true,
		      minlength: 1
		    },
		    txtListDescripcion: {
		      required: true,
		      minlength: 5
		    },
		    txtListEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtUsuUsuario: {
		      required: true,
		      minlength: 1,
		    },
		    txtUsuEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtUsuNombre: {
		      required: true,
		      minlength: 1,
		    },
		    txtUsuIdEmpleado: {
		      required: true,
		      minlength: 1,
		    },
		    txtUsuPassword: {
		      required: true,
		      minlength: 1,
		    },
		    txtUsuConfirmaPassword: {
		      required: true,
		      minlength: 1,
		    },
		    txtEmpDNI: {
		      required: true,
		      minlength: 1,
		    },
		    txtEmpNombre: {
		      required: true,
		      minlength: 1,
		    },
		    txtEmpDireccion: {
		      required: true,
		      minlength: 1,
		    },
		    txtEmpTelefono: {
		      required: true,
		      minlength: 1,
		    },
		    txtEmpEmail: {
		      required: true,
		      minlength: 1,
		    },
		    txtEmpCargo: {
		      required: true,
		      minlength: 1,
		    },
		    txtEmpEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtCiuIdCiudad: {
		      required: true,
		      minlength: 1,
		    },
		    txtCiuNombre: {
		      required: true,
		      minlength: 1,
		    },
		    txtCiuEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtCliTipoDoc: {
		      required: true,
		      minlength: 1,
		    },
		    txtCliDNI: {
		      required: true,
		      minlength: 1,
		    },
		    txtCliNombre: {
		      required: true,
		      minlength: 1,
		    },
		    txtCliFecha: {
		      required: true,
		      minlength: 1,
		    },
		    txtCliIdUsuario: {
		      required: true,
		      minlength: 1,
		    },
		    txtCliIdIngresa: {
		      required: true,
		      minlength: 1,
		    },
		    txtCliIdPais: {
		      required: true,
		      minlength: 1,
		    },
		    txtCliEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtCiuEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtCityIdCiudad: {
		      required: true,
		      minlength: 1,
		    },
		    txtCityEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtFacilNombre: {
		      required: true,
		      minlength: 1,
		    },
		    txtFacilEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtEStNombre: {
		      required: true,
		      minlength: 1,
		    },
		    txtEstEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlTipo: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlTag: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlActuador: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlValvula: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlEspecifico: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlCuerpo: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlCV: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlAir: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlPosicionador: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlRegulador: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlObsoleto: {
		      required: true,
		      minlength: 1,
		    },
		    txtControlProximo: {
		      required: true,
		      minlength: 1,
		    },
		    txtEstEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtEstEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtEstEstado: {
		      required: true,
		      minlength: 1,
		    },
		    txtEstEstado: {
		      required: true,
		      minlength: 1,
		    }
        }
	});


    // Prepare the preview for profile picture
    $("#wizard-picture").change(function(){
        readURL(this);
    });

    $('[data-toggle="wizard-radio"]').click(function(){
        wizard = $(this).closest('.wizard-card');
        wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
        $(this).addClass('active');
        $(wizard).find('[type="radio"]').removeAttr('checked');
        $(this).find('[type="radio"]').attr('checked','true');
    });

    $('[data-toggle="wizard-checkbox"]').click(function(){
        if( $(this).hasClass('active')){
            $(this).removeClass('active');
            $(this).find('[type="checkbox"]').removeAttr('checked');
        } else {
            $(this).addClass('active');
            $(this).find('[type="checkbox"]').attr('checked','true');
        }
    });

    $('.set-full-height').css('height', 'auto');

});



 //Function to show image before upload

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(window).resize(function(){
    $('.wizard-card').each(function(){
        $wizard = $(this);
        index = $wizard.bootstrapWizard('currentIndex');
        refreshAnimation($wizard, index);

        $('.moving-tab').css({
            'transition': 'transform 0s'
        });
    });
});

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
};
