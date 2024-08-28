/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/components/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      screens: {
        'laptop': '1024px',
        'desktop' : '1920px',
        'tablet': '768px'
      },
      fontSize: {
        "60px": "60px",
        "80px": "80px"
      },
      spacing: {
        "50px": "50px"
      },
      backgroundImage: {
        "gradient-radial": "radial-gradient(var(--tw-gradient-stops))",
        "gradient-conic":
          "conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))",
      },
      colors: {
        'color-tertiary': '#00ffff',
      },
      minHeight: {
        'ht-175': '175px',
        'ht-190': '190px',
      },
      width: {
        '49': '49%',
      }
    },
  },
  plugins: [],
};
