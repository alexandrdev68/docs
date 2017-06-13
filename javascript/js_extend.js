/**
 * Created by sasha on 19.04.17.
 */

class JSExtend {

    constructor() {

    }

    /***
     *
     * @param type (string, integer, float, strToArray, strToArrayFloat)
     * @param value
     * @returns {*}
     */
    static toType(type, value) {
        switch (type) {
            case 'string' :
                return String(value);
                break;
            case 'integer' :
                return parseInt(value);
                break;
            case 'float' :
                return parseFloat(value);
                break;
            case 'strToArray':
                return value.split(',');
                break;
            case 'strToArrayFloat':
                let tmp = value.split(',');
                for (let num = 0; num < tmp.length; num++) {
                    tmp[num] = JSExtend.toType('float', tmp[num]);
                }
                return tmp;
                break;
            default:
                return value;
        }
    }


    /***
     *
     * @param arraySource
     * @param find
     * @returns {number of index if find value in passed array, -1 if not found, false wrong parameter}
     */
    static inArray(arraySource, find) {
        if (typeof(arraySource) != 'object') return false;
        if (typeof(find) == 'object') {
            for (let num = 0; num < arraySource.length; num++) {
                for (let fnum = 0; fnum < find.length; fnum++) {
                    if (arraySource[num] === find[fnum]) return num;
                }
            }
            return -1;
        } else if (typeof(find) == 'string' || typeof(find) == 'number') {
            for (let num = 0; num < arraySource.length; num++) {
                if (arraySource[num] === find) return num;
            }
            return -1;
        } else return false;
    }


    /***
     * format amount - set whitespaces
     */
    static amountFormat(number) {
        number = Number(number);
        number = number.toFixed(2);
        number = number.toString();
        if (!/(^[\-0-9]{1,}[\.\,]{0,1}[0-9]{0,}$)/.test(number)) return false;
        number = number.split(',').join('.');
        let arNum = number.split('.');
        let numLen = arNum[0].length;
        if (numLen <= 3) return number;
        let numFormatted = [];
        let sep = 3;
        let inc = Math.ceil(numLen / 3 - 1);
        let g = numLen - 1 + inc;
        for (let i = g; i >= 0; i--) {
            numFormatted[g] = arNum[0][i - inc];
            sep--;
            if (sep == 0) {
                g--;
                numFormatted[g] = ' ';
                sep = 3;
            }
            g--;
        }
        numFormatted = numFormatted.join('');
        return numFormatted += arNum.length == 1 ? '' : '.' + arNum[1];
    }


    static validate(type, value) {
        let reg = {
            wallet_number : '^[0-9]{16,16}$',
            email : '^[a-zA-Z0-9][-._a-zA-Z0-9]+@(?:[-a-zA-Z0-9]+\.)+[a-zA-Z]{2,6}$',
            phone : '^[\+]{0,1}[0-9]{12,12}$',
            amount : '^([0-9]{1,})$|^[0-9]{1,}[.,](?:[0-9]{1,2})$',
            digits : '^[0-9]{1,}$'
        };

        let r_obj = new RegExp(reg[type]);
        return r_obj.test(value);
    }


    /**
     * example:
     * let dec = new Declense({
     *       declensions : {
     *         0:'секунд',
     *         1:'секунда',
     *         2:'секунди',
     *         3:'секунди',
     *         4:'секунди'
     *       }
     *    })
     * dec.getWord(2); (returned - секунда)
     * @param params
     */

    Declense(params){
        params = params  || {};
        this.declensions = params.declensions || {};

        this.getWord = function(num){
            let ak;
            if(num > 20){
                ak = num % 10;
            }else{
                ak = num % 100;
            }
            for(let n in this.declensions){
                if(n == ak){
                    return this.declensions[n];
                }
                return this.declensions[0];
            }
        }
    }


    static getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if (pair[0] == variable) {
                return pair[1];
            }
        }
        console.log('Query Variable ' + variable + ' not found');
    }


}

export default JSExtend;
