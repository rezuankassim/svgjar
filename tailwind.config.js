const hexRgb = require('hex-rgb');
const defaultTheme = require('tailwindcss/defaultTheme');

const makeShadow = (name, rgb) => {
    const obj = {}
    obj[`${name}-xs`] = `0 0 0 1px rgba(${rgb}, 0.05)`
    obj[`${name}-xs`] = `0 0 0 1px rgba(${rgb}, 0.05)`
    obj[`${name}-sm`] = `0 1px 2px 0 rgba(${rgb}, 0.05)`
    obj[name] = `0 1px 3px 0 rgba(${rgb}, 0.1), 0 1px 2px 0 rgba(${rgb}, 0.06)`
    obj[`${name}-md`] = `0 4px 6px -1px rgba(${rgb}, 0.1), 0 2px 4px -1px rgba(${rgb}, 0.06)`
    obj[`${name}-lg`] = `0 10px 15px -3px rgba(${rgb}, 0.1), 0 4px 6px -2px rgba(${rgb}, 0.05)`
    obj[`${name}-xl`] = `0 20px 25px -5px rgba(${rgb}, 0.1), 0 10px 10px -5px rgba(${rgb}, 0.04)`
    obj[`${name}-2xl`] = `0 25px 50px -12px rgba(${rgb}, 0.25)`
    obj[`${name}-inner`] = `inset 0 2px 4px 0 rgba(${rgb}, 0.06)`
    return obj
}

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
            },
            boxShadow: theme => {
                // Handle color objects as well
                const fresh = Object.values(
                    Object.entries(theme('colors')).reduce((acc, curr) => {
                        const [k, v] = curr
                        if (typeof v === 'string' && v !== 'transparent' && v !== 'currentColor') {
                            const { red, green, blue } = hexRgb(v)
                            acc[k] = makeShadow(k, `${red}, ${green}, ${blue}`)
                        }
                        if (typeof v === 'object') {
                            Object.entries(v).forEach(([_k, _v]) => {
                                const { red, green, blue } = hexRgb(_v)
                                acc[`${k}-${_k}`] = makeShadow(
                                    `${k}-${_k}`,
                                    `${red}, ${green}, ${blue}`,
                                )
                            })
                        }
                        return acc
                    }, {}),
                ).reduce((acc, cur) => ({ ...acc, ...cur }), {})
    
                return {
                    ...defaultTheme.boxShadow,
                    ...fresh,
                }
            },
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled', 'group-hover'],
    },

    plugins: [require('@tailwindcss/ui')],
};
