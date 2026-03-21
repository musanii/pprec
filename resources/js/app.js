import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'



window.Alpine = Alpine
Alpine.plugin(intersect)


Alpine.data('counter', (target) => ({

    value: 0,
    target: target,
    duration: 1500,
    startTime: null,

    animate(timestamp) {

        if (!this.startTime) this.startTime = timestamp

        const progress = timestamp - this.startTime
        const percentage = Math.min(progress / this.duration, 1)

        // Ease-out cubic
        const eased = 1 - Math.pow(1 - percentage, 3)

        this.value = Math.floor(this.target * eased)

        if (progress < this.duration) {
            requestAnimationFrame(this.animate.bind(this))
        } else {
            this.value = this.target
        }

    },

    start() {
        requestAnimationFrame(this.animate.bind(this))
    },

    observe(el) {

        const observer = new IntersectionObserver((entries) => {

            if (entries[0].isIntersecting) {
                this.start()
                observer.disconnect()
            }

        }, { threshold: 0.5 })

        observer.observe(el)

    }

}))


Alpine.start()