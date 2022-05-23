//animation list: flip, slice, box3D, pixel, fade, glide, card

$(document).ready(function () {

    $('#slideWiz').slideWiz({
        auto: true,
        speed: 5000,
        row: 12,
        col: 35,
        animation: [
            'flip',
            'slice',
            'box3D',
           
            'fade',
            'glide',
            'card'
        ],
        file: [
            {
                src: {
                    main: "assets/home/image/silder/slider-3.jpeg",
                    cover: "assets/home/image/silder/slider-3.jpg"
                },
                title: 'Banner 1',
                desc: "If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. or randomised words which don't look even slightly believable.",
                descLength: 220,
                button: {
                    text: 'Shop Now',
                    url: '#',
                    class: 'btn btn-medium btn-primary'
                }
            },
            {
                src: {
                    main: "assets/home/image/silder/slider-6.jpeg",
                    cover: "assets/home/image/silder/slider-2.jpg"
                },
                title: 'Banner 2',
                desc: "If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. or randomised words which don't look even slightly believable.",
                button: {
                    text: 'Shop Now',
                    url: '#',
                    class: 'btn btn-medium btn-primary'
                }
            },
            {
                src: {
                    main: "assets/home/image/silder/slider-1.jpeg",
                    cover: "assets/home/image/silder/slider-1.jpg"
                },
                title: 'Banner 3',
                desc: "If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. or randomised words which don't look even slightly believable.",
                descLength: 190,
                button: {
                    text: 'Shop Now',
                    url: '#',
                    class: 'btn btn-medium btn-primary'
                }
            },
            {
                src: {
                    main: "assets/home/image/silder/slider-6.jpeg",
                    cover: "assets/home/image/silder/slider-5.jpg"
                },
                title: 'Banner 4',
                desc: "If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. or randomised words which don't look even slightly believable.",
                button: {
                    text: 'Shop Now',
                    url: false,
                    class: 'btn btn-medium btn-primary'
                }
            }
        ]

    });

});
