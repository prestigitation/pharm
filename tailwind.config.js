module.exports = {
    purge: [

        './src/**/*.html',

        './src/**/*.js',

    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: { sans: ['Inter var'] },
        }
    },
    variants: {},
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/ui'),
    ]
}