import domReady from '@wordpress/dom-ready';
import Splide from '@splidejs/splide';
import '@splidejs/splide/css';

function printMessage( message: string ) {
	console.log( message );
}

document.addEventListener( 'DOMContentLoaded', function () {
	let splide = new Splide( '.splide', {
		type		: 'loop',
		lazyLoad	: true,
		autoplay	: true,
		interval	: 5000,
		perPage		: 4,
		fixedHeight	: 370,
		gap        	: 37.33,
		rewind     	: true,
		breakpoints: {
			1200: {
				perPage			: 3,
				gap				: 16,
			},
			1024: {
				perPage			: 3,
				fixedHeight		: 300,
				arrows			: false,
				gap				: 16,
			},
			768: {
				perPage			: 1,
				focus			: 'center',
				fixedHeight		: 300,
				arrows			: false,
				padding			: '20%',
				gap				: 16,
			}
		}
	} ).mount();

	splide.on( 'click', function (e) {
		const id = e.slide.getAttribute('data-id');
		const ajax_object = window.maximum_slider_ajax_object;
		const url = ajax_object.ajaxurl;
		const nonce = ajax_object.nonce;

		let requestData = {
			action:"maximum_slider_slide_click",
			id: id,
			nonce: nonce,
		};

		fetch( url, {
			method:"post",
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: new URLSearchParams(requestData).toString(),
		}).then(function(response) {
			if (response.status == 200) {
	            return response.json();
			} else {
				return false;
			}
		}).then(function(response) {
			if (response && response.success) {
				const modal = document.querySelector('.maximum-slider-modal-window');
				const backdrop = document.querySelector('.maximum-slider-modal-window__backdrop');
				const contentText = modal.querySelector('.maximum-slider-modal-window__content-text');

				if (contentText) {
					contentText.innerHTML = response.title + ' ' + response.content;
				}

				modalHandler(modal, backdrop);
			}
		});
	} );

	const backdropElement = document.querySelector('.maximum-slider-modal-window__backdrop');
	const modalBtnClose = document.querySelector('.maximum-slider-modal-window__content-close');
	if (backdropElement) {
		backdropElement.addEventListener('click', function () {
			hideModal(document.querySelector('.maximum-slider-modal-window.show'), backdropElement);
		});
	}
	if (modalBtnClose) {
		modalBtnClose.addEventListener('click', function () {
			hideModal(document.querySelector('.maximum-slider-modal-window.show'), backdropElement);
		});
	}
} );

function modalHandler(modal, backdrop) {
	if (modal) {
		showModal(modal, backdrop);
	}
}

function showModal(modalElem, backdrop) {
	modalElem.classList.add('show');
	backdrop.classList.remove('hidden');
}

function hideModal(modalElem, backdrop) {
	modalElem.classList.remove('show');
	backdrop.classList.add('hidden');
}
