class SqrtHelper {
    constructor(a, b = -1) {
        if (b < 0) {
            this.a = 1;
            this.b = a;
        } else {
            this.a = a;
            this.b = b;
        }
        // console.log(this.a, this.b);
        this.simplify();
    }

    squared() {
        return this.a * this.a * this.b;
    }

    mul(x) {
        this.a *= x.a;
        this.b *= x.b;
        return this.simplify();
    }

    simplify() {
        let temp = 0;
        for (let i = Math.floor(Math.sqrt(this.b)); i >= 1 && temp == 0; i--) {
            if (this.b % (i * i) == 0) {
                temp = i;
                this.b /= (i * i);
            }
        }
        // console.log(this.a, this.b);
        this.a *= temp;
        return this;
    }
}
SqrtHelper.prototype.toString = function () {
    if (this.a == 0 || this.b == 0) {
        return "0";
    } else if (this.b == 1) {
        return this.a + "";
    } else if (this.a == 1) {
        return `\\sqrt{${this.b}}`;
    } else {
        return `${this.a}\\sqrt{${this.b}}`;
    }
}

function gcd(a, b) {
    if (a % b == 0) {
        return b;
    } else {
        return gcd(b, a % b);
    }
}

class FracHelper {
    constructor(a = 1, b = 1) {
        this.a = a;
        this.b = b;
        this.simplify();
    }

    simplify() {
        let ctr = 0;
        // console.log("a");
        // console.log(this.a);
        // console.log(this.b);
        while (Math.floor(this.a) != this.a || Math.floor(this.b) != this.b) {
            ctr++;
            this.a *= 30;
            this.b *= 30;
            console.log("b");
        }
        // console.log("====");
        // console.log(this.a);
        // console.log(this.b);
        // console.log("====");
        let g = gcd(this.a, this.b);
        // while (ctr > 0) {
        //     ctr--;
        //     this.a /= 30;
        //     this.b /= 30;
        // }
        // console.log("====");
        // console.log(this.a);
        // console.log(this.b);
        // console.log("====");
        this.a = myRound(this.a / g);
        this.b = myRound(this.b / g);
        // console.log("====");
        // console.log(this.a);
        // console.log(this.b);
        // console.log("====");
        return this;
    }
}
FracHelper.prototype.toString = function () {
    if (this.b == 1) {
        return this.a + "";
    } else {
        return `\\frac{${this.a}}{${this.b}}`;
    }
}

class SqrtFracHelper {
    constructor(a, b) {
        // console.log("wkwkwk");
        // console.log(a);
        // console.log(b);
        this.a = a;
        this.b = b;
        this.rationalize();
    }

    mul(x) {
        this.a.a *= x.a.a;
        this.a.b *= x.a.b;
        this.b.a *= x.b.a;
        this.b.b *= x.b.b;
        this.rationalize();
        return this;
    }

    squared() {
        return new FracHelper(this.a.squared(), this.b.squared());
    }

    rationalize() {
        // console.log("kwkwkw");
        // console.log(this.a);
        // console.log(this.b);
        const a = new SqrtHelper(this.a.squared() * this.b.b);
        const b = new SqrtHelper(this.b.squared() * this.b.b);
        this.a.a = a.a;
        this.a.b = a.b;
        this.b.a = b.a;
        this.b.b = b.b;
        return this.simplify();
    }

    simplify() {
        // console.log("zxcv");
        // console.log(this.a);
        // console.log(this.b);
        const a = new FracHelper(this.a.a, this.b.a),
            b = new FracHelper(this.a.b, this.b.b);
        this.a.a = a.a;
        this.a.b = b.a;
        this.b.a = a.b;
        this.b.b = b.b;
        // console.log("vcxz");
        // console.log(a);
        // console.log(b);
        return this;
    }
}
SqrtFracHelper.prototype.toString = function () {
    const a = this.a + "",
        b = this.b + "";
    if (b == "1") {
        return a;
    } else {
        return `\\frac{${a}}{${b}}`;
    }
}

function myDist(a, b, scaleL, scaleW, scaleH) {
    let x = a.x - b.x,
        y = a.y - b.y,
        z = a.z - b.z;
    return new SqrtFracHelper(new SqrtHelper(myRound((x * x * scaleL * scaleL + y * y * scaleH * scaleH + z * z * scaleW * scaleW) * 129600)), new SqrtHelper(129600));
}