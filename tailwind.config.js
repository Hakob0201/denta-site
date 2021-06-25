module.exports = {
  purge: [
      './resources/views/**/*.php',
      './resources/js/**/*.js',
  ],
  theme: {
    container: {
      center: true,
    },
    fill: {
      current: 'currentColor',
      none: 'none !important',
    },
    fontFamily: {
      sans: ['"Noto Sans Armenian"', '"Noto Sans"', 'sans-serif'],
    },
    colors: {
      primary: {
          '20': '#D3D2DD',
          '50': '#767CA3',
          '100': '#001845',
      },
      secondary: '#14B5B5',
      red: '#F43457',
      green: '#7DB98A',
      orange: '#FDC785',
      black: '#000000',
      white: '#FFFFFF',
      light: '#F4F4F7',
      lighter: '#FAFAFA',
      none: 'transparent',
    },
    opacity: {
      '0': '0',
      '10': '0.1',
      '20': '0.2',
      '30': '0.3',
      '50': '0.5',
      '60': '0.6',
      '80': '0.8',
      '100': '1',
    },
    fontSize: {
      '12': ['0.75rem', '0.75rem'],
      '14': ['0.875rem', '1.1875rem'],
      '15': ['0.9375rem', '1.25rem'],
      '16': ['1rem', '1.375rem'],
      '18': ['1.125rem', '1.5625rem'],
      '20': ['1.25rem', '1.6875rem'],
      '22': ['1.375rem', '1.875rem'],
      '24': ['1.5rem', '2.0625rem'],
      '28': ['1.75rem', '2.375rem'],
    },
    spacing: {
      px: '1px',
      '0': '0',
      '12': '0.75rem',
      '16': '1rem',
      '22': '1.375rem',
      '26': '1.625rem',
      '30': '1.875rem',
      '45': '2.8125rem',
    },
    boxShadow: {
      default: '0px 3px 8px rgba(33, 29, 86, 0.1)',
      light: '0px 4px 4px rgba(6, 16, 88, 0.06)',
      lighter: '0px 2px 10px rgba(6, 16, 88, 0.06)',
      none: 'none',
    },
    extend: {
        screens: {
            'print': {'raw': 'print'},
        }
    },
  },
  variants: {},
  plugins: [],
}
