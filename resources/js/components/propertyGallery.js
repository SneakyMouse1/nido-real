import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import { Fancybox } from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';

export default function propertyGallery(photoCount) {
    return {
        videoOpen: false,
        swiper: null,
        _lightboxHandler: null,

        init() {
            if (photoCount > 0 && this.$refs.swiperContainer) {
                this.swiper = new Swiper(this.$refs.swiperContainer, {
                    modules: [Navigation, Pagination],
                    loop: true,
                    loopedSlides: photoCount,
                    grabCursor: true,
                    speed: 480,
                    observer: true,
                    observeParents: true,

                    navigation: {
                        prevEl: this.$refs.prevBtn,
                        nextEl: this.$refs.nextBtn,
                    },

                    pagination: {
                        el: this.$refs.pagination,
                        clickable: true,
                    },

                    breakpoints: {
                        1024: {
                            slidesPerView: 1.9,
                            spaceBetween: 12,
                            centeredSlides: true,
                        },
                        0: {
                            slidesPerView: 1,
                            spaceBetween: 0,
                            centeredSlides: false,
                        }
                    },

                    on: {
                        slideChange: (s) => {
                            if (this.$refs.counter) {
                                this.$refs.counter.textContent = `${s.realIndex + 1} / ${photoCount}`;
                            }
                        }
                    },
                });
            }

            this._lightboxHandler = () => {
                const startIndex = this.swiper ? this.swiper.realIndex : 0;

                const items = Array.from(
                    document.querySelectorAll('[data-fancybox="property-gallery"]')
                ).map(el => ({
                    src: el.dataset.src,
                    caption: el.dataset.caption || '',
                    type: 'image',
                }));

                if (items.length === 0) return;

                Fancybox.show(items, {
                    startIndex,
                    animated: true,
                    dragToClose: true,
                    Toolbar: {
                        display: {
                            left: ['infobar'],
                            middle: [],
                            right: ['slideshow', 'fullscreen', 'download', 'close'],
                        },
                    },
                    Images: {
                        zoom: true,
                    },
                    Carousel: {
                        transition: 'slide',
                        infinite: true,
                    },
                });
            };

            window.addEventListener('open-lightbox', this._lightboxHandler);
        },

        destroy() {
            if (this.swiper) {
                this.swiper.destroy(true, true);
                this.swiper = null;
            }
            if (this._lightboxHandler) {
                window.removeEventListener('open-lightbox', this._lightboxHandler);
                this._lightboxHandler = null;
            }
            Fancybox.destroy();
        }
    };
}
