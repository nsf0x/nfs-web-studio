/** @type {import('tailwindcss').Config} */
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    extend: {
      colors: {
        navy: {
          DEFAULT: '#0B1F3A',
          50:  '#E8EDF3',
          100: '#C5D0E0',
          200: '#9FB0C9',
          300: '#7890B2',
          400: '#5A759F',
          500: '#3B5A8C',
          600: '#2E4A74',
          700: '#1E3457',
          800: '#142340',
          900: '#0B1F3A',
        },
        gold: {
          DEFAULT: '#C9A227',
          light:   '#E8C94A',
          dark:    '#A07E18',
        },
        accent: {
          DEFAULT: '#2563EB',
          hover:   '#1D4ED8',
        },
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      borderRadius: {
        '2xl': '16px',
        '3xl': '24px',
      },
      boxShadow: {
        card:  '0 2px 20px 0 rgba(11,31,58,0.08)',
        hover: '0 8px 32px 0 rgba(11,31,58,0.14)',
      },
    },
  },
  plugins: [forms, typography],
};
