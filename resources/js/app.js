import './bootstrap'

import Alpine from 'alpinejs'
import collapse from '@alpinejs/collapse'
import PerfectScrollbar from 'perfect-scrollbar'

window.PerfectScrollbar = PerfectScrollbar

document.addEventListener('alpine:init', () => {
    Alpine.data('mainState', () => {
        let lastScrollTop = 0
        let ticking = false

        const onScroll = (ctx) => {
            if (ticking) {
                return
            }

            ticking = true
            window.requestAnimationFrame(() => {
                const currentScrollTop =
                    window.pageYOffset || document.documentElement.scrollTop

                if (currentScrollTop > lastScrollTop) {
                    ctx.scrollingDown = true
                    ctx.scrollingUp = false
                } else {
                    ctx.scrollingDown = false
                    ctx.scrollingUp = currentScrollTop > 0
                }

                if (currentScrollTop === 0) {
                    ctx.scrollingDown = false
                    ctx.scrollingUp = false
                }

                lastScrollTop = Math.max(currentScrollTop, 0)
                ticking = false
            })
        }

        const init = function () {
            window.addEventListener('scroll', () => onScroll(this), {
                passive: true,
            })
            this.handleWindowResize()
        }

        const getTheme = () => {
            if (window.localStorage.getItem('dark')) {
                return JSON.parse(window.localStorage.getItem('dark'))
            }

            return (
                !!window.matchMedia &&
                window.matchMedia('(prefers-color-scheme: dark)').matches
            )
        }

        const setTheme = (value) => {
            window.localStorage.setItem('dark', value)
        }

        return {
            init,
            isDarkMode: getTheme(),
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode
                setTheme(this.isDarkMode)
            },
            isSidebarOpen: window.innerWidth > 1024,
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return
                }
                this.isSidebarHovered = value
            },
            handleWindowResize() {
                this.isSidebarOpen = window.innerWidth > 1024
            },
            scrollingDown: false,
            scrollingUp: false,
        }
    })
})

Alpine.plugin(collapse)

Alpine.start()
