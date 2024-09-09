/**
 * @package     CouponCode
 * @version     1.0
 * @author      Trevor Wagner
 */
export default class Certificate {
    constructor() {
        this.canvas = null;
        this.url = null;
        this.name = null;
        this.link = null;

        this.init();

        return this;
    }

    init() {
        const canvas = $('[data-certificate-canvas]');

        if(canvas.length > 0){
            const link = $('[data-cert-download-link]');
            
            this.canvas = canvas;
            this.url = canvas.data('imageUrl');
            this.name = canvas.data('certName');

            if(link.length){
                this.link = link;
            }
            
            this.loadCertificate();
        }
    }

    loadCertificate() {
        const self = this;
        const ctx = self.canvas[0].getContext('2d');
    
        let img = new Image();
        img.src = self.url;

        img.addEventListener("load", () => {
            
            const ratio = img.naturalWidth / img.naturalHeight;
            const width = self.canvas.width();
            const height = width / ratio;

            self.canvas.attr('width', width)
            self.canvas.attr('height', height)

            if(width > 768){
                ctx.font = '50px Helvetica Neue Light';
            } else {
                ctx.font = '20px Helvetica Neue Light';
            }

            ctx.drawImage(img, 0, 0, width, height);

            const txtWidth = ctx.measureText(self.name);
            ctx.fillText(self.name, ((width/2) - (txtWidth.width/2)), (height/2));

            self.setDownloadUrl();
        });
    }

    setDownloadUrl(){
        const self = this;
        const downloadLink = self.canvas[0].toDataURL("image/jpg");
        self.link.attr('href', downloadLink);
        self.link.attr('download', 'completion-certificate-' + self.name.replace(' ', '-') + '.jpg');
    }

}