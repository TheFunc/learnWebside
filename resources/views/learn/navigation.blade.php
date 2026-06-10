@extends('learn.layouts')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- 标语横幅 -->
    <div class="nav-hero">
        <div class="hero-pattern"></div>
        <div class="hero-content">
            <div class="hero-icon">
                <i class="fa-solid fa-compass"></i>
            </div>
            <h1 class="hero-title">编程工具导航</h1>
            <p class="hero-subtitle">精选开发工具，助力高效编程，让每一行代码都更加优雅</p>
            <div class="hero-divider"></div>
        </div>
        <div class="hero-glow"></div>
    </div>

    <!-- 前端开发 -->
    <div class="category-row mb-6">
        <div class="category-header">
            <span class="category-icon bg-blue-100"><i class="fa-brands fa-html5 text-blue-500"></i></span>
            <h2 class="category-title">前端开发</h2>
        </div>
        <div class="tools-scroll">
            <a href="https://nodejs.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-green-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#83CD29" d="M113.8 61.2c-0.3-0.2-0.7-0.3-1-0.3-1.1 0-2.1 0.6-2.7 1.5-0.6 0.9-0.6 2.1 0 3 0.6 0.9 1.6 1.5 2.7 1.5 0.3 0 0.7-0.1 1-0.3 1.3-0.8 1.7-2.4 0.9-3.7-0.2-0.6-0.5-1.2-0.9-1.7z"/><path fill="#83CD29" d="M64 0C28.7 0 0 28.7 0 64s28.7 64 64 64 64-28.7 64-64S99.3 0 64 0z"/></svg>
                </div>
                <span class="tool-label">Node.js</span>
            </a>
            <a href="https://www.npmjs.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#C12127" width="128" height="128"/><rect fill="#FFF" x="24" y="40" width="20" height="48"/><rect fill="#FFF" x="52" y="40" width="20" height="28"/><rect fill="#FFF" x="80" y="40" width="20" height="48"/></svg>
                </div>
                <span class="tool-label">npm</span>
            </a>
            <a href="https://vitejs.dev" target="_blank" class="tool-item">
                <div class="tool-icon bg-purple-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#646CFF" d="M48 0L0 64l48 64 80-128z"/><path fill="#BDDBFF" d="M48 0L0 64h48V0z"/></svg>
                </div>
                <span class="tool-label">Vite</span>
            </a>
            <a href="https://webpack.js.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#8ED6FB" d="M104.5 22.5L64 8 23.5 22.5 64 37z"/><path fill="#8ED6FB" d="M64 120l40.5-14.5V70L64 84.5z"/><path fill="#8ED6FB" d="M64 120L23.5 105.5V70L64 84.5z"/><path fill="#1C78C0" d="M64 84.5L23.5 70l40.5-33 40.5 33z"/><path fill="#1C78C0" d="M64 37l-40.5-14.5V70L64 84.5z"/><path fill="#1C78C0" d="M64 37l40.5-14.5V70L64 84.5z"/></svg>
                </div>
                <span class="tool-label">Webpack</span>
            </a>
            <a href="https://react.dev" target="_blank" class="tool-item">
                <div class="tool-icon bg-cyan-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="11.4" fill="#61DAFB"/><ellipse cx="64" cy="64" rx="42" ry="14" fill="none" stroke="#61DAFB" stroke-width="3.6"/><ellipse cx="64" cy="64" rx="42" ry="14" fill="none" stroke="#61DAFB" stroke-width="3.6" transform="rotate(60 64 64)"/><ellipse cx="64" cy="64" rx="42" ry="14" fill="none" stroke="#61DAFB" stroke-width="3.6" transform="rotate(120 64 64)"/></svg>
                </div>
                <span class="tool-label">React</span>
            </a>
            <a href="https://vuejs.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-emerald-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#41B883" d="M78.4 0L64 25 49.6 0H0l64 112L128 0z"/><path fill="#41B883" d="M78.4 0L64 25 49.6 0H25.6L64 67.2 102.4 0z"/><path fill="#35495E" d="M25.6 0L64 67.2 102.4 0H78.4L64 25 49.6 0z"/></svg>
                </div>
                <span class="tool-label">Vue.js</span>
            </a>
            <a href="https://angular.dev" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#DD0031" d="M64 0l-56 32 10 72 46 24 46-24 10-72z"/><path fill="#C3002F" d="M64 0v128l46-24 10-72z"/><path fill="#FFF" d="M64 16L32 80h12l6-14h28l6 14h12L64 16zm0 32l-8 20h16l-8-20z"/></svg>
                </div>
                <span class="tool-label">Angular</span>
            </a>
            <a href="https://tailwindcss.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-sky-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#06B6D4" d="M48 32C28 32 16 48 16 64s12 32 32 32c8 0 16-4 20-8-4-4-8-12-8-20 0-12 8-24 20-28-4-4-12-8-20-8zm32 0c-8 0-16 4-20 8 12 4 20 16 20 28 0 8-4 16-8 20 4 4 12 8 20 8 20 0 32-16 32-32S112 32 80 32z"/></svg>
                </div>
                <span class="tool-label">Tailwind CSS</span>
            </a>
            <a href="https://www.typescriptlang.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#3178C6" width="128" height="128"/><path fill="#FFF" d="M32 40h16v48H32zm24 0h16v32h16V40h16v48H88V56H72v32H56z"/></svg>
                </div>
                <span class="tool-label">TypeScript</span>
            </a>
            <a href="https://sass-lang.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-pink-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#CC6699" d="M64 0C28.7 0 0 28.7 0 64s28.7 64 64 64 64-28.7 64-64S99.3 0 64 0zm32 80c-8 8-20 12-32 12s-24-4-32-12c-4-4-4-12 0-16 4-4 12-4 16 0 4 4 12 8 16 8s12-4 16-8c4-4 12-4 16 0 4 4 4 12 0 16z"/></svg>
                </div>
                <span class="tool-label">SASS</span>
            </a>
            <a href="https://jquery.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#0769AD" width="128" height="128"/><path fill="#FFF" d="M32 64c0-12 8-24 20-28l-4-12c-16 6-28 22-28 40s12 34 28 40l4-12c-12-4-20-16-20-28zm64 0c0-18-12-34-28-40l-4 12c12 4 20 16 20 28s-8 24-20 28l4 12c16-6 28-22 28-40z"/></svg>
                </div>
                <span class="tool-label">jQuery</span>
            </a>
            <a href="https://nextjs.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-slate-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#000"/><path fill="#FFF" d="M48 88V40h8l24 32V40h8v48h-8L56 56v32z"/></svg>
                </div>
                <span class="tool-label">Next.js</span>
            </a>
        </div>
    </div>

    <!-- 后端开发 -->
    <div class="category-row mb-6">
        <div class="category-header">
            <span class="category-icon bg-indigo-100"><i class="fa-solid fa-server text-indigo-500"></i></span>
            <h2 class="category-title">后端开发</h2>
        </div>
        <div class="tools-scroll">
            <a href="https://www.php.net" target="_blank" class="tool-item">
                <div class="tool-icon bg-indigo-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#777BB4" d="M20 32h24l4 16h-20c-4 0-8 4-8 8v32c0 4 4 8 8 8h12c4 0 8-4 8-8v-8h16v8c0 4 4 8 8 8h12c4 0 8-4 8-8V48c0-4-4-8-8-8H88l4-16h24V32H20z"/></svg>
                </div>
                <span class="tool-label">PHP</span>
            </a>
            <a href="https://getcomposer.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-amber-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#52669E" d="M64 8L16 36v56l48 28 48-28V36z"/><path fill="#FFF" d="M64 20L28 40v48l36 20 36-20V40z"/><path fill="#52669E" d="M64 32L40 48v32l24 16 24-16V48z"/></svg>
                </div>
                <span class="tool-label">Composer</span>
            </a>
            <a href="https://laravel.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#FF2D20" d="M108.6 16H63.4L38.2 41.2 19.4 60 63.4 104l45.2-45.2V16z"/><path fill="#FFF" d="M63.4 28L44.6 46.8 63.4 65.6l18.8-18.8z"/></svg>
                </div>
                <span class="tool-label">Laravel</span>
            </a>
            <a href="https://www.python.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-yellow-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#3776AB" d="M63.5 10c-24 0-22 10-22 10v12h22v4H28S2 32 2 64s22 28 22 28h12V76s0-12 12-12h20s12 0 12-12V32S82 10 63.5 10zM51.5 18c3 0 6 3 6 6s-3 6-6 6-6-3-6-6 3-6 6-6z"/><path fill="#FFD43B" d="M64.5 118c24 0 22-10 22-10v-12h-22v-4h36s26 4 26-28-22-28-22-28H92v12s0 12-12 12H60s-12 0-12 12v28s0 28 16.5 28zm12-8c-3 0-6-3-6-6s3-6 6-6 6 3 6 6-3 6-6 6z"/></svg>
                </div>
                <span class="tool-label">Python</span>
            </a>
            <a href="https://www.djangoproject.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-green-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#092E20" width="128" height="128"/><path fill="#44B78B" d="M32 40h12v48H32zm24 0h12v48H56zm24 0h12v48H80z"/></svg>
                </div>
                <span class="tool-label">Django</span>
            </a>
            <a href="https://flask.palletsprojects.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-slate-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#000" d="M64 16L24 64h80z"/><path fill="#FFF" d="M24 64v48l40 32 40-32V64z"/></svg>
                </div>
                <span class="tool-label">Flask</span>
            </a>
            <a href="https://go.dev" target="_blank" class="tool-item">
                <div class="tool-icon bg-cyan-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#00ADD8" d="M100 28c-4-8-12-12-20-12-12 0-20 8-20 20 0 8 4 16 12 20-4 4-8 12-8 20 0 12 8 20 20 20 8 0 16-4 20-12 4 4 12 8 20 8 12 0 20-8 20-20 0-8-4-16-12-20 4-4 8-12 8-20 0-12-8-20-20-20-8 0-16 4-20 12-4-8-12-12-20-12z"/></svg>
                </div>
                <span class="tool-label">Go</span>
            </a>
            <a href="https://www.rust-lang.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="56" fill="#000"/><path fill="#FFF" d="M64 20c-24 0-44 20-44 44s20 44 44 44 44-20 44-44-20-44-44-44zm0 8c20 0 36 16 36 36s-16 36-36 36-36-16-36-36 16-36 36-36z"/><circle cx="64" cy="64" r="12" fill="#FFF"/></svg>
                </div>
                <span class="tool-label">Rust</span>
            </a>
            <a href="https://www.java.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#5382A1" d="M48 88s-4 4 8 6c12 2 16 2 28 0 0 0 4-4-8-6-12-2-16-2-28 0z"/><path fill="#E76F00" d="M44 76s-4 4 8 6c12 2 20 2 32 0 0 0 4-4-8-6-12-2-20-2-32 0z"/><path fill="#5382A1" d="M64 20c-24 0-40 12-40 28 0 12 8 20 20 24-4-8-4-16 0-24 8-12 24-16 36-12 12 4 16 16 12 28-4 8-12 12-20 16 16-4 28-16 28-32 0-16-16-28-36-28z"/></svg>
                </div>
                <span class="tool-label">Java</span>
            </a>
            <a href="https://spring.io/projects/spring-boot" target="_blank" class="tool-item">
                <div class="tool-icon bg-green-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#6DB33F" d="M64 8L16 56l48 48 48-48z"/><path fill="#6DB33F" d="M64 8v96l48-48z"/><path fill="#FFF" d="M64 40L40 64l24 24 24-24z"/></svg>
                </div>
                <span class="tool-label">Spring Boot</span>
            </a>
            <a href="https://dotnet.microsoft.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-purple-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="56" fill="#512BD4"/><path fill="#FFF" d="M48 40h32v48H48z"/></svg>
                </div>
                <span class="tool-label">.NET</span>
            </a>
            <a href="https://www.ruby-lang.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#CC342D" d="M64 4L12 52l52 72 52-72z"/><path fill="#FFF" d="M64 20L28 56l36 52 36-52z"/></svg>
                </div>
                <span class="tool-label">Ruby</span>
            </a>
            <a href="https://rubyonrails.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#CC0000" d="M64 4L12 52l52 72 52-72z"/><path fill="#FFF" d="M64 20L28 56l36 52 36-52z"/></svg>
                </div>
                <span class="tool-label">Rails</span>
            </a>
        </div>
    </div>

    <!-- 编程语言 -->
    <div class="category-row mb-6">
        <div class="category-header">
            <span class="category-icon bg-violet-100"><i class="fa-solid fa-code text-violet-500"></i></span>
            <h2 class="category-title">编程语言</h2>
        </div>
        <div class="tools-scroll">
            <a href="https://www.python.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-yellow-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#3776AB" d="M64 0C36 0 38 12 38 12v14h28v4H28S0 26 0 64s24 38 24 38h14V88s0-14 14-14h24s14 0 14-14V28S92 0 64 0zM44 8c4 0 8 4 8 8s-4 8-8 8-8-4-8-8 4-8 8-8z"/><path fill="#FFD43B" d="M64 128c28 0 26-12 26-12v-14H62v-4h38s28 4 28-34-24-38-24-38H90v14s0 14-14 14H52s-14 0-14 14v32s0 28 26 28zm20-8c-4 0-8-4-8-8s4-8 8-8 8 4 8 8-4 8-8 8z"/></svg>
                </div>
                <span class="tool-label">Python</span>
            </a>
            <a href="https://www.java.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#5382A1" d="M48 88s-4 4 8 6c12 2 16 2 28 0 0 0 4-4-8-6-12-2-16-2-28 0z"/><path fill="#E76F00" d="M44 76s-4 4 8 6c12 2 20 2 32 0 0 0 4-4-8-6-12-2-20-2-32 0z"/><path fill="#5382A1" d="M64 20c-24 0-40 12-40 28 0 12 8 20 20 24-4-8-4-16 0-24 8-12 24-16 36-12 12 4 16 16 12 28-4 8-12 12-20 16 16-4 28-16 28-32 0-16-16-28-36-28z"/></svg>
                </div>
                <span class="tool-label">Java</span>
            </a>
            <a href="https://go.dev" target="_blank" class="tool-item">
                <div class="tool-icon bg-cyan-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#00ADD8" d="M96 32c-8-8-20-12-32-12C36 20 16 40 16 64s20 44 48 44c12 0 24-4 32-12 4-4 4-12 0-16-4-4-12-4-16 0-4 4-12 8-16 8-16 0-28-12-28-28s12-28 28-28c4 0 12 4 16 8 4 4 12 4 16 0 4-4 4-12 0-16z"/></svg>
                </div>
                <span class="tool-label">Go</span>
            </a>
            <a href="https://www.rust-lang.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#000"/><path fill="#FFF" d="M64 24c-22 0-40 18-40 40s18 40 40 40 40-18 40-40-18-40-40-40zm0 12c16 0 28 12 28 28s-12 28-28 28-28-12-28-28 12-28 28-28z"/></svg>
                </div>
                <span class="tool-label">Rust</span>
            </a>
            <a href="https://www.cprogramming.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#00599C"/><text x="64" y="80" text-anchor="middle" font-size="56" font-weight="bold" fill="#FFF" font-family="sans-serif">C</text></svg>
                </div>
                <span class="tool-label">C</span>
            </a>
            <a href="https://cplusplus.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#00599C"/><text x="52" y="80" text-anchor="middle" font-size="48" font-weight="bold" fill="#FFF" font-family="sans-serif">C++</text></svg>
                </div>
                <span class="tool-label">C++</span>
            </a>
            <a href="https://www.ruby-lang.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#CC342D" d="M64 0L16 48l48 80 48-80z"/><path fill="#FFF" d="M64 24L32 56l32 48 32-48z"/></svg>
                </div>
                <span class="tool-label">Ruby</span>
            </a>
            <a href="https://www.swift.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#FA7343" d="M64 0L16 48l48 80 48-80z"/><path fill="#FFF" d="M64 24L32 56l32 48 32-48z"/></svg>
                </div>
                <span class="tool-label">Swift</span>
            </a>
            <a href="https://kotlinlang.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-purple-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#7F52FF" width="128" height="128"/><path fill="#FFF" d="M64 0L0 64l64 64 64-64z"/></svg>
                </div>
                <span class="tool-label">Kotlin</span>
            </a>
            <a href="https://www.scala-lang.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#DC322F" d="M64 0L16 48l48 80 48-80z"/><path fill="#FFF" d="M64 24L32 56l32 48 32-48z"/></svg>
                </div>
                <span class="tool-label">Scala</span>
            </a>
            <a href="https://www.php.net" target="_blank" class="tool-item">
                <div class="tool-icon bg-indigo-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#777BB4" d="M4 64c0-22 18-40 40-40h40c22 0 40 18 40 40s-18 40-40 40H44C22 104 4 86 4 64zm36-24c-4 0-8 4-8 8v8c0 4 4 8 8 8h8c4 0 8-4 8-8v-8c0-4-4-8-8-8h-8zm40 0c-4 0-8 4-8 8v8c0 4 4 8 8 8h8c4 0 8-4 8-8v-8c0-4-4-8-8-8h-8z"/></svg>
                </div>
                <span class="tool-label">PHP</span>
            </a>
            <a href="https://www.typescriptlang.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#3178C6" width="128" height="128"/><path fill="#FFF" d="M32 40h16v48H32zm24 0h16v32h16V40h16v48H88V56H72v32H56z"/></svg>
                </div>
                <span class="tool-label">TypeScript</span>
            </a>
        </div>
    </div>

    <!-- C/C++ 工具 -->
    <div class="category-row mb-6">
        <div class="category-header">
            <span class="category-icon bg-slate-100"><i class="fa-solid fa-gears text-slate-600"></i></span>
            <h2 class="category-title">C/C++ 工具</h2>
        </div>
        <div class="tools-scroll">
            <a href="https://gcc.gnu.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-slate-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#FF4B4B"/><text x="64" y="76" text-anchor="middle" font-size="36" font-weight="bold" fill="#FFF" font-family="sans-serif">GCC</text></svg>
                </div>
                <span class="tool-label">GCC</span>
            </a>
            <a href="https://clang.llvm.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#A13"/><text x="64" y="76" text-anchor="middle" font-size="32" font-weight="bold" fill="#FFF" font-family="sans-serif">Clang</text></svg>
                </div>
                <span class="tool-label">Clang</span>
            </a>
            <a href="https://cmake.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#064F8C" d="M64 8L16 36v56l48 28 48-28V36z"/><path fill="#FFF" d="M64 20L28 40v48l36 20 36-20V40z"/></svg>
                </div>
                <span class="tool-label">CMake</span>
            </a>
            <a href="https://visualstudio.microsoft.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-purple-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#5C2D91" d="M64 8L16 36v56l48 28 48-28V36z"/><path fill="#FFF" d="M64 20L28 40v48l36 20 36-20V40z"/></svg>
                </div>
                <span class="tool-label">Visual Studio</span>
            </a>
            <a href="https://www.mingw-w64.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-green-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#0078D4"/><text x="64" y="76" text-anchor="middle" font-size="28" font-weight="bold" fill="#FFF" font-family="sans-serif">MinGW</text></svg>
                </div>
                <span class="tool-label">MinGW</span>
            </a>
            <a href="https://codeblocks.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#2D7D9A" d="M64 8L16 36v56l48 28 48-28V36z"/><path fill="#FFF" d="M64 20L28 40v48l36 20 36-20V40z"/></svg>
                </div>
                <span class="tool-label">Code::Blocks</span>
            </a>
            <a href="https://www.qt.io" target="_blank" class="tool-item">
                <div class="tool-icon bg-green-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#41CD52"/><text x="64" y="76" text-anchor="middle" font-size="40" font-weight="bold" fill="#FFF" font-family="sans-serif">Qt</text></svg>
                </div>
                <span class="tool-label">Qt</span>
            </a>
        </div>
    </div>

    <!-- 数据库 -->
    <div class="category-row mb-6">
        <div class="category-header">
            <span class="category-icon bg-emerald-100"><i class="fa-solid fa-database text-emerald-500"></i></span>
            <h2 class="category-title">数据库</h2>
        </div>
        <div class="tools-scroll">
            <a href="https://www.mysql.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#4479A1" d="M64 8L16 36v56l48 28 48-28V36z"/><path fill="#FFF" d="M36 40c-4 0-8 4-8 8v32c0 4 4 8 8 8h8c4 0 8-4 8-8V48c0-4-4-8-8-8h-8zm24 0c-4 0-8 4-8 8v32c0 4 4 8 8 8h8c4 0 8-4 8-8V48c0-4-4-8-8-8h-8zm24 0c-4 0-8 4-8 8v32c0 4 4 8 8 8h8c4 0 8-4 8-8V48c0-4-4-8-8-8h-8z"/></svg>
                </div>
                <span class="tool-label">MySQL</span>
            </a>
            <a href="https://www.postgresql.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#336791" d="M64 8C36 8 16 28 16 56c0 20 12 36 28 44l4 20h32l4-20c16-8 28-24 28-44 0-28-20-48-48-48z"/><path fill="#FFF" d="M48 40h32v48H48z"/></svg>
                </div>
                <span class="tool-label">PostgreSQL</span>
            </a>
            <a href="https://www.mongodb.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-green-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#00684A" d="M64 8C36 8 16 28 16 56c0 16 8 28 20 36l-4 28h64l-4-28c12-8 20-20 20-36 0-28-20-48-48-48z"/><circle cx="64" cy="48" r="16" fill="#00ED64"/></svg>
                </div>
                <span class="tool-label">MongoDB</span>
            </a>
            <a href="https://redis.io" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#DC382D" d="M64 8C36 8 16 28 16 56c0 20 12 36 28 44l4 20h32l4-20c16-8 28-24 28-44 0-28-20-48-48-48z"/><path fill="#FFF" d="M48 40h32v48H48z"/></svg>
                </div>
                <span class="tool-label">Redis</span>
            </a>
            <a href="https://www.sqlite.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-slate-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#003B57" d="M64 8C36 8 16 28 16 56c0 20 12 36 28 44l4 20h32l4-20c16-8 28-24 28-44 0-28-20-48-48-48z"/><path fill="#FFF" d="M40 48c0-4 4-8 8-8h32c4 0 8 4 8 8v32c0 4-4 8-8 8H48c-4 0-8-4-8-8V48z"/></svg>
                </div>
                <span class="tool-label">SQLite</span>
            </a>
            <a href="https://mariadb.org" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#003545" d="M64 8C36 8 16 28 16 56c0 20 12 36 28 44l4 20h32l4-20c16-8 28-24 28-44 0-28-20-48-48-48z"/><path fill="#FFF" d="M48 40h32v48H48z"/></svg>
                </div>
                <span class="tool-label">MariaDB</span>
            </a>
            <a href="https://www.oracle.com/database" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#F80000" d="M64 8C36 8 16 28 16 56c0 20 12 36 28 44l4 20h32l4-20c16-8 28-24 28-44 0-28-20-48-48-48z"/><path fill="#FFF" d="M48 40h32v48H48z"/></svg>
                </div>
                <span class="tool-label">Oracle</span>
            </a>
            <a href="https://www.microsoft.com/sql-server" target="_blank" class="tool-item">
                <div class="tool-icon bg-purple-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#5C2D91" d="M64 8C36 8 16 28 16 56c0 20 12 36 28 44l4 20h32l4-20c16-8 28-24 28-44 0-28-20-48-48-48z"/><path fill="#FFF" d="M48 40h32v48H48z"/></svg>
                </div>
                <span class="tool-label">SQL Server</span>
            </a>
        </div>
    </div>

    <!-- 开发工具 -->
    <div class="category-row mb-6">
        <div class="category-header">
            <span class="category-icon bg-violet-100"><i class="fa-solid fa-toolbox text-violet-500"></i></span>
            <h2 class="category-title">开发工具</h2>
        </div>
        <div class="tools-scroll">
            <a href="https://code.visualstudio.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#007ACC" d="M16 20l64 44-64 44V20z"/><path fill="#007ACC" d="M112 20L48 64l64 44V20z"/><path fill="#FFF" d="M48 64L16 20v88l32-44z"/></svg>
                </div>
                <span class="tool-label">VS Code</span>
            </a>
            <a href="https://www.jetbrains.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-red-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#000" width="128" height="128"/><path fill="#FFF" d="M32 32h24v64H32zm20 0h24v64H52zm20 0h24v64H72z"/></svg>
                </div>
                <span class="tool-label">JetBrains</span>
            </a>
            <a href="https://www.jetbrains.com/idea" target="_blank" class="tool-item">
                <div class="tool-icon bg-black/5">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#000" width="128" height="128"/><path fill="#FFF" d="M32 32h24v64H32zm20 0h24v64H52zm20 0h24v64H72z"/></svg>
                </div>
                <span class="tool-label">IntelliJ IDEA</span>
            </a>
            <a href="https://www.jetbrains.com/pycharm" target="_blank" class="tool-item">
                <div class="tool-icon bg-yellow-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#000" width="128" height="128"/><path fill="#FFF" d="M32 32h24v64H32zm20 0h24v64H52zm20 0h24v64H72z"/></svg>
                </div>
                <span class="tool-label">PyCharm</span>
            </a>
            <a href="https://www.sublimetext.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-yellow-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#FF9800" width="128" height="128"/><path fill="#FFF" d="M32 32h64v64H32z"/></svg>
                </div>
                <span class="tool-label">Sublime Text</span>
            </a>
            <a href="https://www.docker.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-blue-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#2496ED" d="M16 64c0-24 20-40 48-40s48 16 48 40-20 40-48 40-48-16-48-40z"/><path fill="#FFF" d="M32 56h8v16h-8zm12 0h8v16h-8zm12 0h8v16h-8zm12 0h8v16h-8z"/></svg>
                </div>
                <span class="tool-label">Docker</span>
            </a>
            <a href="https://www.postman.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#FF6C37" d="M64 8C36 8 16 28 16 56c0 20 12 36 28 44l4 20h32l4-20c16-8 28-24 28-44 0-28-20-48-48-48z"/><path fill="#FFF" d="M48 40h32v48H48z"/></svg>
                </div>
                <span class="tool-label">Postman</span>
            </a>
            <a href="https://git-scm.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#F05032" d="M64 8C36 8 16 28 16 56c0 20 12 36 28 44l4 20h32l4-20c16-8 28-24 28-44 0-28-20-48-48-48z"/><path fill="#FFF" d="M64 32c-8 0-16 4-20 12-4 8-4 16 0 24 4 8 12 12 20 12 8 0 16-4 20-12 4-8 4-16 0-24-4-8-12-12-20-12z"/></svg>
                </div>
                <span class="tool-label">Git</span>
            </a>
        </div>
    </div>

    <!-- 平台 & 社区 -->
    <div class="category-row mb-6">
        <div class="category-header">
            <span class="category-icon bg-sky-100"><i class="fa-solid fa-globe text-sky-500"></i></span>
            <h2 class="category-title">平台 & 社区</h2>
        </div>
        <div class="tools-scroll">
            <a href="https://github.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-gray-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#1B1F23"/><path fill="#FFF" d="M64 24c-22 0-40 18-40 40 0 18 12 32 28 38 2 0 4-2 4-4v-12c-8 2-10-4-10-4-2-4-4-6-4-6-4-4 0-4 0-4 4 0 6 4 6 4 4 6 10 4 12 4 0-2 2-4 2-4 2-4 0-8 0-8 8-2 16-4 16-16 0-4-2-8-4-10 0 0-2 0-4 2 0 0-4-2-12-2-8 0-12 2-12 2-2-2-4-2-4-2-2 2-4 2-4 2-2 2-4 6-4 10 0 12 8 14 16 16 0 2-2 4-2 6v14c0 2 2 4 4 4 16-6 28-20 28-38 0-22-18-40-40-40z"/></svg>
                </div>
                <span class="tool-label">GitHub</span>
            </a>
            <a href="https://gitlab.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#FC6D26" d="M64 8L24 56l-8 48h96l-8-48z"/><path fill="#E24329" d="M64 8L24 56h80z"/><path fill="#FCA326" d="M16 104h96l-8-48H24z"/></svg>
                </div>
                <span class="tool-label">GitLab</span>
            </a>
            <a href="https://stackoverflow.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#F48024" width="128" height="128"/><path fill="#FFF" d="M32 72h64v8H32zm8-16h48v8H40zm8-16h32v8H48zm8-16h16v8H56zM32 88h64v16H32z"/></svg>
                </div>
                <span class="tool-label">Stack Overflow</span>
            </a>
            <a href="https://www.figma.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-purple-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><path fill="#F24E1E" d="M48 8C36 8 32 16 32 24v32c0 8 4 16 16 16h16c8 0 16-8 16-16V24c0-8-8-16-16-16H48z"/><path fill="#A259FF" d="M48 72c-12 0-16 8-16 16v16c0 8 4 16 16 16h16c8 0 16-8 16-16V88c0-8-8-16-16-16H48z"/><path fill="#1ABCFE" d="M80 40c8 0 16 8 16 16v16c0 8-8 16-16 16H64V40h16z"/></svg>
                </div>
                <span class="tool-label">Figma</span>
            </a>
            <a href="https://vercel.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-slate-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><circle cx="64" cy="64" r="60" fill="#000"/><path fill="#FFF" d="M64 24l40 64H24z"/></svg>
                </div>
                <span class="tool-label">Vercel</span>
            </a>
            <a href="https://aws.amazon.com" target="_blank" class="tool-item">
                <div class="tool-icon bg-orange-50">
                    <svg viewBox="0 0 128 128" class="tool-svg"><rect fill="#FF9900" width="128" height="128"/><path fill="#FFF" d="M48 72c-8 0-16 4-16 12s8 12 16 12c8 0 16-4 16-12s-8-12-16-12zm32 0c-8 0-16 4-16 12s8 12 16 12c8 0 16-4 16-12s-8-12-16-12z"/><path fill="#232F3E" d="M40 40h48v8H40zm0 16h48v8H40z"/></svg>
                </div>
                <span class="tool-label">AWS</span>
            </a>
        </div>
    </div>
</div>

<style>
/* ========== 标语横幅 ========== */
.nav-hero {
    position: relative;
    margin-bottom: 32px;
    padding: 48px 40px;
    background: linear-gradient(135deg, #ffffff 0%, var(--blue-50) 40%, var(--blue-100) 100%);
    border-radius: 20px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    text-align: center;
}

.nav-hero .hero-pattern {
    position: absolute;
    inset: 0;
    opacity: 0.04;
    background-image: 
        radial-gradient(circle at 20% 50%, var(--blue-500) 1px, transparent 1px),
        radial-gradient(circle at 80% 20%, var(--accent-cyan) 1px, transparent 1px),
        radial-gradient(circle at 60% 80%, var(--blue-400) 1px, transparent 1px);
    background-size: 40px 40px, 60px 60px, 50px 50px;
    pointer-events: none;
}

.nav-hero .hero-content {
    position: relative;
    z-index: 2;
}

.nav-hero .hero-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    background: linear-gradient(135deg, var(--blue-500), var(--accent-cyan));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25);
    animation: heroIconPulse 3s ease-in-out infinite;
}

.nav-hero .hero-icon i {
    font-size: 1.6rem;
    color: white;
}

@keyframes heroIconPulse {
    0%, 100% { transform: scale(1); box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25); }
    50% { transform: scale(1.05); box-shadow: 0 12px 32px rgba(59, 130, 246, 0.35); }
}

.nav-hero .hero-title {
    font-family: 'Noto Sans SC', sans-serif;
    font-weight: 900;
    font-size: 1.75rem;
    letter-spacing: 0.12em;
    margin: 0 0 12px;
    background: linear-gradient(
        135deg,
        var(--blue-600) 0%,
        var(--accent-cyan) 50%,
        var(--blue-500) 100%
    );
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradientShift 4s linear infinite;
}

.nav-hero .hero-subtitle {
    font-size: 0.95rem;
    color: var(--text-secondary);
    margin: 0 0 16px;
    letter-spacing: 0.05em;
    line-height: 1.6;
}

.nav-hero .hero-divider {
    width: 80px;
    height: 3px;
    margin: 0 auto;
    background: linear-gradient(90deg, transparent, var(--blue-400), var(--accent-cyan), var(--blue-400), transparent);
    border-radius: 2px;
}

.nav-hero .hero-glow {
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    width: 60%;
    height: 40px;
    background: radial-gradient(ellipse, rgba(59, 130, 246, 0.15), transparent 70%);
    pointer-events: none;
}

@keyframes gradientShift {
    0% { background-position: 0% center; }
    100% { background-position: 200% center; }
}

.category-row {
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    padding: 1.25rem 1.5rem;
    box-shadow: var(--shadow-sm);
    text-align: center;
}

.category-header {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--border-color);
}

.category-icon {
    width: 2rem;
    height: 2rem;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    flex-shrink: 0;
}

.category-icon i {
    font-size: 1rem;
}

.category-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
}

.tools-scroll {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    justify-content: center;
    align-items: center;
    padding-bottom: 0.5rem;
    text-align: center;
}

.tool-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 110px;
    padding: 1rem 0.5rem;
    border-radius: 0.75rem;
    text-decoration: none;
    transition: all 0.2s ease;
}

.tool-item:hover {
    background: var(--blue-50);
    transform: translateY(-3px);
}

.tool-icon {
    width: 4rem;
    height: 4rem;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.75rem;
    transition: transform 0.2s ease;
}

.tool-item:hover .tool-icon {
    transform: scale(1.15);
}

.tool-svg {
    width: 2rem;
    height: 2rem;
}

.tool-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-secondary);
    text-align: center;
    white-space: nowrap;
    transition: color 0.2s ease;
}

.tool-item:hover .tool-label {
    color: var(--blue-600);
}
</style>
@endsection
