#!/bin/bash

# Iniciar Apache en segundo plano
apache2-foreground &

# Iniciar Vite (npm run dev)
npm list vite
npm run dev
