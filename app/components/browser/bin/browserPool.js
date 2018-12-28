var debug = require('debug')('server:browserPagePool')
const genericPool = require('generic-pool')
const puppeteer = require('puppeteer')

// 具体到时候这里就可以是部署地址，通过js来进行页面的跳转
// const url = 'http://www.baidu.com'

const factory = {
    create: async function () {
        try {
            debug('launching browser')
            const browser = await puppeteer.launch({})

            debug('opening new page')
            const page = await browser.newPage()

            // debug('setting viewport')
            // await page.setViewport({
            //     width: 800,
            //     height: 420,
            //     deviceScaleFactor: 1.5,
            // })

            // debug('going to' + url)
            // await page.goto(url, {
            //     waitUntil: 'networkidle0',
            //     timeout: 6000
            // })

            debug('returning page')
            return page
        } catch (e) {
            console.error('browserPagePool error creating browser page', e)
        }
    },

    destroy: function(puppeteer) {
        debug('closing broswer')
        puppeteer.close()
    }
}

const browserPool = genericPool.createPool(factory, {
    max: 10,
    min: 2,
    maxWaitingClients: 20,
    autostart: false
})

module.exports = browserPool
