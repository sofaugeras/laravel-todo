// vite.config.js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/sass/app.scss', 'resources/js/app.js'],
      refresh: true,
    }),
    vue(),
  ],
  css: {
    preprocessorOptions: {
      scss: {
        quietDeps: true, // << masque les warnings provenant de node_modules
      },
    },
  },
  resolve: {
    alias: { '@': path.resolve(__dirname, 'resources/js') },
  },
})
