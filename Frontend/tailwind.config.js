/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [],
  theme: {
    extend: {},
  },
  plugins: [],
}
module.exports = {
  content: [
    'node_modules/flowbite-vue//*.{js,jsx,ts,tsx,vue}',
    'node_modules/flowbite//*.{js,jsx,ts,tsx}'
  ],
  plugins: [
      require('flowbite/plugin')
  ],
theme:{}
}