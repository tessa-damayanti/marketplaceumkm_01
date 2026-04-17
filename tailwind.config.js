module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        primary: "#a78d78",
        secondary: "#8f7561",
        accent: "#5c4432",
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
   