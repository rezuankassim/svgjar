const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'hot-pink': '#fd2d78',
            },
            rotate: {
                ...defaultTheme.rotate,
                '-10': '-10deg',
                '-9': '-9deg',
                '-8': '-8deg',
                '-7': '-7deg',
                '-6': '-6deg',
                '-5': '-5deg',
                '-4': '-4deg',
                '-3': '-3deg',
                '-2': '-2deg',
                '-1': '-1deg',
                '1': '1deg',
                '2': '2deg',
                '3': '3deg',
                '4': '4deg',
                '5': '5deg',
                '6': '6deg',
                '7': '7deg',
                '8': '8deg',
                '9': '9deg',
                '10': '10deg',
            },
            spacing: {
                ...defaultTheme.spacing,
                '7': '1.75rem',
                '9': '2.25rem',
                '14': '3.5rem',
                '22': '5.5rem',
                '26': '6.5rem',
                '28': '7rem',
                '30': '7.5rem',
                '34': '8.5rem',
                '36': '9rem',
                '38': '9.5rem',
                '44': '11rem',
                '52': '13rem',
                '60': '15rem',
                '68': '17rem',
                '72': '18rem',
                '76': '19rem',
                '80': '20rem',
                '88': '22rem',
                '96': '24rem',
                '104': '26rem',
                '110': '28rem',
                '118': '30rem',
                '126': '32rem',
                '132': '34rem',
                '140': '36rem',
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled', 'group-hover'],
    },

    plugins: [require('@tailwindcss/ui')],
};
