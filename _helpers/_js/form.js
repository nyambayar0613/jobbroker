/**
* /application/_helpers/_js/form.js
* @author Netfu
* @since 2012/04/22
* @last update 2015/04/08
* @Module v3.0 ( Alice )
* @Brief :: Form Validate Script
* @Comment :: Form 검증 및 필드 확인 Javascript
*/

/// 에러메시지 포멧 정의 ///
var NO_BLANK = "{name+을를} 입력하여 주십시오.";
var NO_CHECK = "{name+을를} 선택하여 주십시오.";
var NOT_VALID = "{name+이가} 올바르지 않습니다.";
var TOO_LONG = "{name}의 길이가 초과되었습니다. (최대 {maxbyte}바이트)";
var SPACE = (navigator.appVersion.indexOf("MSIE")!=-1) ? "          " : "";

/// 스트링 객체에 메소드 추가 ///
String.prototype.trim = function(str) { 
	str = this != window ? this : str; 
	return str.replace(/^\s+/g,'').replace(/\s+$/g,''); 
}

String.prototype.hasFinalConsonant = function(str) {
	str = this != window ? this : str; 
	var strTemp = str.substr(str.length-1);
	return ((strTemp.charCodeAt(0)-16)%28!=0);
}

String.prototype.bytes = function(str) {
	str = this != window ? this : str;
	var len = 0;
	for(var j=0; j<str.length; j++) {
		var chr = str.charAt(j);
		len += (chr.charCodeAt() > 128) ? 2 : 1
	}
	return len;
}

String.prototype.number_format=function(){
	return this.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');
}

Array.prototype.shuffle = function() { 
	return this.concat().sort(function() {
		return Math.random() - Math.random();
	});
}

if ( ! String.prototype.repeat ) {
	/**
	 * object.x(number)
	 * object.repeat(number)
	 * Transform the string object multiplying the string
	 *
	 * @param       number  Amount of repeating
	 * @return      string
	 * @access      public
	 * @see         http://svn.debugger.ru/repos/jslibs/BrowserExtensions/trunk/ext/string.js
	 * @see         http://wiki.ecmascript.org/doku.php?id=harmony:string_extras
	 */
	String.prototype.repeat = function(n){
			n = Math.max(n || 0, 0);
			return new Array(n + 1).join(this.valueOf());
	};
}

if ( ! String.prototype.startsWith ) {
	/**
	 * Returns true if the sequence of characters of searchString converted 
	 * to a String match the corresponding characters of this object 
	 * (converted to a String) starting at position. Otherwise returns false.
	 *
	 * @param       string
	 * @param       integer
	 * @return      bollean
	 * @acess       public
	 */
	String.prototype.startsWith = function(searchString, position){
			position = Math.max(position || 0, 0);
			return this.indexOf(searchString) == position;
	};
}

if ( ! String.prototype.endsWith ) {
	/**
	 * Returns true if the sequence of characters of searchString converted 
	 * to a String match the corresponding characters of this object 
	 * (converted to a String) starting at endPosition - length(this). 
	 * Otherwise returns false.
	 *
	 * @param       string
	 * @param       integer
	 * @return      bollean
	 * @acess       public
	 */
	String.prototype.endsWith = function(searchString, endPosition){
			endPosition = Math.max(endPosition || 0, 0);
			var s = String(searchString);
			var pos = this.lastIndexOf(s);
			return pos >= 0 && pos == this.length - s.length - endPosition;
	};
}

if ( ! String.prototype.contains ) {
	/**
	 * If searchString appears as a substring of the result of converting 
	 * this object to a String, at one or more positions that are greater than 
	 * or equal to position, then return true; otherwise, returns false. 
	 * If position is undefined, 0 is assumed, so as to search all of the String.
	 *
	 * @param       string
	 * @param       integer
	 * @return      bollean
	 * @acess       public
	 */
	String.prototype.contains = function(searchString, position){
			position = Math.max(position || 0, 0);
			return this.indexOf(searchString) != -1;
	};

}

if ( ! String.prototype.toArray ) {
	/**
	 * Returns an Array object with elements corresponding to 
	 * the characters of this object (converted to a String).
	 *
	 * @param       void
	 * @return      array
	 * @acess       public
	 */
	String.prototype.toArray = function(){
			return this.split('');
	};
}

if ( ! String.prototype.reverse ) {
	/**
	 * Returns an Array object with elements corresponding to 
	 * the characters of this object (converted to a String) in reverse order.
	 *
	 * @param       void
	 * @return      string
	 * @acess       public
	 */
	String.prototype.reverse = function(){
			return this.split('').reverse().join('');
	};
}

/*
The following ode is not described in ECMA specs or drafts.
*/

/**
 * String.validBrackets(string)
 * Checks string to be valid brackets. Valid brackets are:
 *      quotes  - '' "" `' ``
 *      single  - <> {} [] () %% || // \\
 *      double  - miltiline comments
 *                /** / C/C++ like (without whitespace)
 *                <??> PHP like
 *                <%%> ASP like
 *                (**) Pascal like
 *
 * @param       string  Brackets (left and right)
 * @return      boolean Result of validity of brackets
 * @access      static
 */
String.validBrackets = function(br){
	if ( ! br ) {
		return false;
	}
	var quot = "''\"\"`'``";
	var sgl = "<>{}[]()%%||//\\\\";
	var dbl = "/**/<??><%%>(**)";
	return (br.length == 2 && (quot + sgl).indexOf(br) != -1) || (br.length == 4 && dbl.indexOf(br) != -1);
};

/**
 * object.bracketize(string)
 * Transform the string object by setting in frame of valid brackets
 *
 * @param       string  Brackets
 * @return      string  Bracketized string
 * @access      public
 */
String.prototype.brace = 
String.prototype.bracketize = function(br) {
	var string = this;
	if ( ! String.validBrackets(br) ) {
			return string;
	}
	var midPos = br.length / 2;
	return br.substr(0, midPos) + string.toString() + br.substr(midPos);
};

/**
 * object.unbracketize(string)
 * Transform the string object removing the leading and trailing brackets
 * If the parameter is not defined the method will try to remove existing valid brackets
 *
 * @param       string  Brackets
 * @return      string  Unbracketized string
 * @access      public
 */
String.prototype.unbrace = 
String.prototype.unbracketize = function(br) {
	var string = this;
	if ( ! br ) {
		var len = string.length;
		for (var i = 2; i >= 1; i--) {
				br = string.substring(0, i) + string.substring(len - i);
				if ( String.validBrackets(br) ) {
						return string.substring(i, len - i);
				}
		}
	}
	if ( ! String.validBrackets(br) ) {
		return string;
	}
	var midPos = br.length / 2;
	var i = string.indexOf(br.substr(0, midPos));
	var j = string.lastIndexOf(br.substr(midPos));
	if (i == 0 && j == string.length - midPos) {
			string = string.substring(i + midPos, j);
	}
	return string;
};

/**
 * object.radix(number, number, string)
 * Transform the number object to string in accordance with a scale of notation
 * If it is necessary the numeric string will aligned to right and filled by '0' character, by default
 *
 * @param       number  Radix of scale of notation (it have to be greater or equal 2 and below or equal 36)
 * @param       number  Width of numeric string
 * @param       string  Padding chacracter (by default, '0')
 * @return      string  Numeric string
 * @access      public
 */
Number.prototype.radix = function(r, n, c){
        return this.toString(r).padding(-n, c);
//      return this.toString(r).padding(-Math.abs(n), c);
};

/**
 * object.bin(number, string)
 * Transform the number object to string of binary presentation
 *
 * @param       number  Width of numeric string
 * @param       string  Padding chacracter (by default, '0')
 * @return      string  Numeric string
 * @access      public
 */
Number.prototype.bin = function(n, c){
        return this.radix(0x02, n, c);
//      return this.radix(0x02, (n) ? n : 16, c);
};

/**
 * object.oct(number, string)
 * Transform the number object to string of octal presentation
 *
 * @param       number  Width of numeric string
 * @param       string  Padding chacracter (by default, '0')
 * @return      string  Numeric string
 * @access      public
 */
Number.prototype.oct = function(n, c){
        return this.radix(0x08, n, c);
//      return this.radix(0x08, (n) ? n : 6, c);
};

/**
 * object.dec(number, string)
 * Transform the number object to string of decimal presentation
 *
 * @param       number  Width of numeric string
 * @param       string  Padding chacracter (by default, '0')
 * @return      string  Numeric string
 * @access      public
 */
Number.prototype.dec = function(n, c){
        return this.radix(0x0A, n, c);
};

/**
 * object.hexl(number, string)
 * Transform the number object to string of hexadecimal presentation in lower-case of major characters (0-9 and a-f)
 *
 * @param       number  Width of numeric string
 * @param       string  Padding chacracter (by default, '0')
 * @return      string  Numeric string
 * @access      public
 */
Number.prototype.hexl = function(n, c){
        return this.radix(0x10, n, c);
//      return this.radix(0x10, (n) ? n : 4, c);
};

/**
 * object.hex(number, string)
 * Transform the number object to string of the hexadecimal presentation 
 * in upper-case of major characters (0-9 and A-F)
 *
 * @param       number  Width of numeric string
 * @param       string  Padding chacracter (by default, '0')
 * @return      string  Numeric string
 * @access      public
 */
Number.prototype.hex = function(n, c){
        return this.radix(0x10, n, c).toUpperCase();
};

/**
 * object.human([digits[, true]])
 * Transform the number object to string in human-readable format (e.h., 1k, 234M, 5G)
 *
 * @example
 * var n = 1001;
 *
 * // will output 1.001K
 * var h = n.human(3);
 *
 * // will output 1001.000
 * var H = n.human(3, true);
 *
 * @param       integer Optional. Number of digits after the decimal point. Must be in the range 0-20, inclusive. 
 * @param       boolean Optional. If true then use powers of 1024 not 1000
 * @return      string  Human-readable string
 * @access      public
 */
Number.prototype.human = function(digits, binary){
        var n = Math.abs(this);
        var p = this;
        var s = '';
        var divs = arguments.callee.add(binary);
        for (var i = divs.length - 1; i >= 0; i--) {
                if ( n >= divs[i].d ) {
                        p /= divs[i].d;
                        s = divs[i].s;
                        break;
                }
        }
        return p.toFixed(digits) + s;
};

/**
 * Subsidiary method. 
 * Stores suffixes and divisors to use in Number.prototype.human. 
 *
 * @param       boolean
 * @param       string
 * @param       divisor
 * @return      array
 * @access      static
 */
Number.prototype.human.add = function(binary, suffix, divisor){
        var name = binary ? 'div2' : 'div10';
        var divs = Number.prototype.human[name] = Number.prototype.human[name] || [];

        if ( arguments.length < 3 ) {
                return divs;
        }

        divs.push({s: suffix, d: Math.abs(divisor)});
        divs.sort(function(a, b)
        {
                return a.d - b.d;
        });

        return divs;
};

// Binary prefixes
Number.prototype.human.add(true,  'K', 1 << 10);
Number.prototype.human.add(true,  'M', 1 << 20);
Number.prototype.human.add(true,  'G', 1 << 30);
Number.prototype.human.add(true,  'T', Math.pow(2, 40));

// Decimal prefixes
Number.prototype.human.add(false, 'K', 1e3);
Number.prototype.human.add(false, 'M', 1e6);
Number.prototype.human.add(false, 'G', 1e9);
Number.prototype.human.add(false, 'T', 1e12);

/**
 * object.fromHuman([digits[, binary]])
 * Transform the human-friendly string to the valid numeriv value
 *
 * @example
 * var n = 1001;
 *
 * // will output 1.001K
 * var h = n.human(3);
 *
 * // will output 1001
 * var m = h.fromHuman(h);
 *
 * @param       boolean Optional. If true then use powers of 1024 not 1000
 * @return      number
 * @access      public
 */
Number.fromHuman = function(value, binary){
        var m = String(value).match(/^([\-\+]?\d+\.?\d*)([A-Z])?$/);
        if ( ! m ) {
                return Number.NaN;
        }
        if ( ! m[2] ) {
                return +m[1];
        }
        var divs = Number.prototype.human.add(binary);
        for (var i = 0; i < divs.length; i++) {
                if ( divs[i].s == m[2] ) {
                        return m[1] * divs[i].d;
                }
        }
        return Number.NaN;
};

if ( ! String.prototype.trim ) {
	/**
	 * object.trim()
	 * Transform the string object removing leading and trailing whitespaces
	 *
	 * @return      string
	 * @access      public
	 */
	String.prototype.trim = function(){
			return this.replace(/(^\s*)|(\s*$)/g, "");
	};
}

if ( ! String.prototype.trimLeft ) {
	/**
	 * object.trimLeft()
	 * Transform the string object removing leading whitespaces
	 *
	 * @return      string
	 * @access      public
	 */
	String.prototype.trimLeft = function(){
			return this.replace(/(^\s*)/, "");
	};
}

if ( ! String.prototype.trimRight ) {
	/**
	 * object.trimRight()
	 * Transform the string object removing trailing whitespaces
	 *
	 * @return      string
	 * @access      public
	 */
	String.prototype.trimRight = function(){
			return this.replace(/(\s*$)/g, "");
	};
}

/**
 * object.dup()
 * Transform the string object duplicating the string
 *
 * @return      string
 * @access      public
 */
String.prototype.dup = function(){
        var val = this.valueOf();
        return val + val;
};

/**
 * object.padding(number, string)
 * Transform the string object to string of the actual width filling by the padding character (by default ' ')
 * Negative value of width means left padding, and positive value means right one
 *
 * @param       number  Width of string
 * @param       string  Padding chacracter (by default, ' ')
 * @return      string
 * @access      public
 */
String.prototype.padding = function(n, c){
        var val = this.valueOf();
        if ( Math.abs(n) <= val.length ) {
                return val;
        }
        var m = Math.max((Math.abs(n) - this.length) || 0, 0);
        var pad = Array(m + 1).join(String(c || ' ').charAt(0));
//      var pad = String(c || ' ').charAt(0).repeat(Math.abs(n) - this.length);
        return (n < 0) ? pad + val : val + pad;
//      return (n < 0) ? val + pad : pad + val;
};

/**
 * object.padLeft(number, string)
 * Wrapper for object.padding
 * Transform the string object to string of the actual width adding the leading padding character (by default ' ')
 *
 * @param       number  Width of string
 * @param       string  Padding chacracter
 * @return      string
 * @access      public
 */
String.prototype.padLeft = function(n, c){
        return this.padding(-Math.abs(n), c);
};

/**
 * object.alignRight(number, string)
 * Wrapper for object.padding
 * Synonym for object.padLeft
 *
 * @param       number  Width of string
 * @param       string  Padding chacracter
 * @return      string
 * @access      public
 */
String.prototype.alignRight = String.prototype.padLeft;
/**
 * object.padRight(number, string)
 * Wrapper for object.padding
 * Transform the string object to string of the actual width adding the trailing padding character (by default ' ')
 *
 * @param       number  Width of string
 * @param       string  Padding chacracter
 * @return      string
 * @access      public
 */
String.prototype.padRight = function(n, c){
        return this.padding(Math.abs(n), c);
};

/**
 * Formats arguments accordingly the formatting string. 
 * Each occurence of the "{\d+}" substring refers to 
 * the appropriate argument. 
 *
 * @example
 * '{0}is not {1} + {2}'.format('JavaScript', 'Java', 'Script');
 *
 * @param       mixed
 * @return      string
 * @access      public
 */
String.prototype.format = function(){
        var args = arguments;
        return this.replace(/\{(\d+)\}/g, function($0, $1)
        {
                return args[$1] !== void 0 ? args[$1] : $0;
        });
};

/**
 * object.alignLeft(number, string)
 * Wrapper for object.padding
 * Synonym for object.padRight
 *
 * @param       number  Width of string
 * @param       string  Padding chacracter
 * @return      string
 * @access      public
 */
String.prototype.alignLeft = String.prototype.padRight;

/**
 * sprintf(format, argument_list)
 *
 * The string function like one in C/C++, PHP, Perl
 * Each conversion specification is defined as below:
 *
 * %[index][alignment][padding][width][precision]type
 *
 * index        An optional index specifier that changes the order of the 
 *              arguments in the list to be displayed.
 * alignment    An optional alignment specifier that says if the result should be 
 *              left-justified or right-justified. The default is 
 *              right-justified; a "-" character here will make it left-justified.
 * padding      An optional padding specifier that says what character will be 
 *              used for padding the results to the right string size. This may 
 *              be a space character or a "0" (zero character). The default is to 
 *              pad with spaces. An alternate padding character can be specified 
 *              by prefixing it with a single quote ('). See the examples below.
 * width        An optional number, a width specifier that says how many 
 *              characters (minimum) this conversion should result in.
 * precision    An optional precision specifier that says how many decimal digits 
 *              should be displayed for floating-point numbers. This option has 
 *              no effect for other types than float.
 * type         A type specifier that says what type the argument data should be 
 *              treated as. Possible types:
 *
 * % - a literal percent character. No argument is required.  
 * b - the argument is treated as an integer, and presented as a binary number.
 * c - the argument is treated as an integer, and presented as the character 
 *      with that ASCII value.
 * d - the argument is treated as an integer, and presented as a decimal number.
 * u - the same as "d".
 * f - the argument is treated as a float, and presented as a floating-point.
 * o - the argument is treated as an integer, and presented as an octal number.
 * s - the argument is treated as and presented as a string.
 * x - the argument is treated as an integer and presented as a hexadecimal 
 *       number (with lowercase letters).
 * X - the argument is treated as an integer and presented as a hexadecimal 
 *       number (with uppercase letters).
 * h - the argument is treated as an integer and presented in human-readable format 
 *       using powers of 1024.
 * H - the argument is treated as an integer and presented in human-readable format 
 *       using powers of 1000.
 */
String.prototype.sprintf = function(){
        var args = arguments;
        var index = 0;

        var x;
        var ins;
        var fn;

        /*
         * The callback function accepts the following properties
         *      x.index contains the substring position found at the origin string
         *      x[0] contains the found substring
         *      x[1] contains the index specifier (as \d+\$ or \d+#)
         *      x[2] contains the alignment specifier ("+" or "-" or empty)
         *      x[3] contains the padding specifier (space char, "0" or defined as '.)
         *      x[4] contains the width specifier (as \d*)
         *      x[5] contains the floating-point precision specifier (as \.\d*)
         *      x[6] contains the type specifier (as [bcdfosuxX])
         */
        return this.replace(String.prototype.sprintf.re, function()
        {
                if ( arguments[0] == "%%" ) {
                        return "%";
                }

                x = [];
                for (var i = 0; i < arguments.length; i++) {
                        x[i] = arguments[i] || '';
                }
                x[3] = x[3].slice(-1) || ' ';

                ins = args[+x[1] ? x[1] - 1 : index++];
//              index++;

                return String.prototype.sprintf[x[6]](ins, x);
        });
};

String.prototype.sprintf.re = /%%|%(?:(\d+)[\$#])?([+-])?('.|0| )?(\d*)(?:\.(\d+))?([bcdfosuxXhH])/g;

String.prototype.sprintf.b = function(ins, x){
        return Number(ins).bin(x[2] + x[4], x[3]);
};
String.prototype.sprintf.c = function(ins, x){
        return String.fromCharCode(ins).padding(x[2] + x[4], x[3]);
};
String.prototype.sprintf.d = 
String.prototype.sprintf.u = function(ins, x){
        return Number(ins).dec(x[2] + x[4], x[3]);
};
String.prototype.sprintf.f = function(ins, x){
        var ins = Number(ins);
//      var fn = String.prototype.padding;
        if (x[5]) {
                ins = ins.toFixed(x[5]);
        } else if (x[4]) {
                ins = ins.toExponential(x[4]);
        } else {
                ins = ins.toExponential();
        }
        // Invert sign because this is not number but string
        x[2] = x[2] == "-" ? "+" : "-";
        return ins.padding(x[2] + x[4], x[3]);
//      return fn.call(ins, x[2] + x[4], x[3]);
};
String.prototype.sprintf.o = function(ins, x){
        return Number(ins).oct(x[2] + x[4], x[3]);
};
String.prototype.sprintf.s = function(ins, x){
        return String(ins).padding(x[2] + x[4], x[3]);
};
String.prototype.sprintf.x = function(ins, x){
        return Number(ins).hexl(x[2] + x[4], x[3]);
};
String.prototype.sprintf.X = function(ins, x){
        return Number(ins).hex(x[2] + x[4], x[3]);
};
String.prototype.sprintf.h = function(ins, x){
        var ins = String.prototype.replace.call(ins, /,/g, '');
        // Invert sign because this is not number but string
        x[2] = x[2] == "-" ? "+" : "-";
        return Number(ins).human(x[5], true).padding(x[2] + x[4], x[3]);
};
String.prototype.sprintf.H = function(ins, x){
        var ins = String.prototype.replace.call(ins, /,/g, '');
        // Invert sign because this is not number but string
        x[2] = x[2] == "-" ? "+" : "-";
        return Number(ins).human(x[5], false).padding(x[2] + x[4], x[3]);
};

/**
 * compile()
 *
 * This string function compiles the formatting string to the internal function 
 * to acelerate an execution a formatting within loops. 
 *
 * @example
 * // Standard usage of the sprintf method
 * var s = '';
 * for (var p in obj) {
 *     s += '%s = %s'.sprintf(p, obj[p]);
 * }
 *
 * // The more speed usage of the sprintf method
 * var sprintf = '%s = %s'.compile();
 * var s = '';
 * for (var p in obj) {
 *     s += sprintf(p, obj[p]);
 * }
 *
 * @see         String.prototype.sprintf()
 */
String.prototype.compile = function(){
        var args = arguments;
        var index = 0;

        var x;
        var ins;
        var fn;

        /*
         * The callback function accepts the following properties
         *      x.index contains the substring position found at the origin string
         *      x[0] contains the found substring
         *      x[1] contains the index specifier (as \d+\$ or \d+#)
         *      x[2] contains the alignment specifier ("+" or "-" or empty)
         *      x[3] contains the padding specifier (space char, "0" or defined as '.)
         *      x[4] contains the width specifier (as \d*)
         *      x[5] contains the floating-point precision specifier (as \.\d*)
         *      x[6] contains the type specifier (as [bcdfosuxX])
         */
        var result = this.replace(/(\\|")/g, '\\$1').replace(String.prototype.sprintf.re, function()
        {
                if ( arguments[0] == "%%" ) {
                        return "%";
                }

                arguments.length = 7;
                x = [];
                for (var i = 0; i < arguments.length; i++) {
                        x[i] = arguments[i] || '';
                }
                x[3] = x[3].slice(-1) || ' ';

                ins = x[1] ? x[1] - 1 : index++;
//              index++;

                return '", String.prototype.sprintf.' + x[6] + '(arguments[' + ins + '], ["' + x.join('", "') + '"]), "';
        });

        return Function('', 'return ["' + result + '"].join("")');
};

/**
 * Considers the string object as URL and returns it's parts separately
 *
 * @param       void
 * @return      Object
 * @access      public
 */
String.prototype.parseUrl = function(){
        var matches = this.match(arguments.callee.re);

        if ( ! matches ) {
                return null;
        }

        var result = {
                'scheme': matches[1] || '',
                'subscheme': matches[2] || '',
                'user': matches[3] || '',
                'pass': matches[4] || '',
                'host': matches[5],
                'port': matches[6] || '',
                'path': matches[7] || '',
                'query': matches[8] || '',
                'fragment': matches[9] || ''};

        return result;
};

String.prototype.parseUrl.re = /^(?:([a-z]+):(?:([a-z]*):)?\/\/)?(?:([^:@]*)(?::([^:@]*))?@)?((?:[a-z0-9_-]+\.)+[a-z]{2,}|localhost|(?:(?:[01]?\d\d?|2[0-4]\d|25[0-5])\.){3}(?:(?:[01]?\d\d?|2[0-4]\d|25[0-5])))(?::(\d+))?(?:([^:\?\#]+))?(?:\?([^\#]+))?(?:\#([^\s]+))?$/i;

String.prototype.camelize = function(){
        return this.replace(/([^-]+)|(?:-(.)([^-]+))/mg, function($0, $1, $2, $3)
        {
                return ($2 || '').toUpperCase() + ($3 || $1).toLowerCase();
        });
};

String.prototype.uncamelize = function(){
        return this
			.replace(/[A-Z]/g, function($0)
			{
					return '-' + $0.toLowerCase();
			});
};


function in_array(value, array, similar) {
	for(var i=0; i<array.length; i++) {
		if(similar==true) {
			if(value.indexOf(array[i]) != -1) return true; // 비슷한 값
		} else {
			if(array[i]==value) return true; // 동일한 값
		}
	}
	return false;
} 

function validate(form, skip) {
	for (var i=0; i<form.elements.length; i++) {
		var el = form.elements[i];
		if (el.tagName == "FIELDSET") continue;
		if(skip && in_array(el.name, skip.split('|'), true) === true) continue;	// 추가
		if(el.type.toLowerCase() != "file" && el.value) el.value = el.value.trim();		// 수정 :: 파폭 보안 문제

		var _type = $(el).attr("type");
		if(_type=='editor') {
			el.value = _editor_use[el.name].outputBodyHTML();
			var _content = _editor_use[el.name].trimSpace(el.value.replace(/(<([^>]+)>)/gi, ""));
		}

		var PATTERN = el.getAttribute("PATTERN");
		var minbyte = el.getAttribute("MINBYTE");
		var maxbyte = el.getAttribute("MAXBYTE");
		var minval = el.getAttribute("MINVAL");
		var maxval = el.getAttribute("MAXVAL");
		var option = el.getAttribute("OPTION");
		var match = el.getAttribute("MATCHING"); // 수정 :: Prototype JS 와 충돌하여 'MATCH' 에서 'MATCHING' 으로 변경
		var glue = el.getAttribute("GLUE");
		var unit = el.getAttribute("UNIT");
		var or = el.getAttribute("OR");
		if(unit == null) unit = '';

		if (el.getAttribute("REQUIRED") != null) {
			var ERR_MSG = (el.getAttribute("MESSAGE") != null) ? el.getAttribute("MESSAGE") : null;
			if ((el.type.toLowerCase() == "radio" || el.type.toLowerCase() == "checkbox") && !checkMultiBox(el)) return (ERR_MSG) ? doError(el,ERR_MSG) : doError(el,NO_CHECK);
			if (el.tagName.toLowerCase() == "select" && (el.value == null || el.value == "")) return (ERR_MSG) ? doError(el,ERR_MSG) : doError(el,NO_CHECK);
			if (el.value == null || el.value == "" ) {
				if(el.type.toLowerCase()!='textarea' || (el.type.toLowerCase()=='textarea' && _type!='editor')) {
					return (ERR_MSG) ? doError(el,ERR_MSG) : doError(el,NO_BLANK);
				}
			}
			if(_type=='editor' && _editor_use[el.name] && !_content) {
				return doError(el,NO_BLANK);
			}
		}
		if (minbyte != null && el.value != "" && el.value.bytes() < parseInt(minbyte)) {
			if(unit=='') unit = "바이트";
			return doError(el,"{name+은는} 최소 "+minbyte+" "+unit+" 이상 입력해야 합니다.");
		}
		if (maxbyte != null && el.value != "" && el.value.bytes() > parseInt(maxbyte)) {
			if(unit=='') unit = "바이트";
			return doError(el,"{name+은는} 최대 "+maxbyte+" "+unit+" 이하로 입력해야 합니다.");
		}
		if (minval != null && el.value != "" && el.value < parseInt(minval)) return doError(el,"{name+은는} 최저 "+minval+" "+unit+" 이상 입력해야 합니다.");
		if (maxval != null && el.value != "" && el.value > parseInt(maxval)) return doError(el,"{name+은는} 최고 "+maxval+" "+unit+" 이하로 입력해야 합니다.");
		if (PATTERN != null && el.value != "" && !PATTERN(el,pattern)) return false;
		if (match != null && (el.value != form.elements[match].value)) return doError(el,"{name+이가} 일치하지 않습니다.");
		if (or != null && (el.value == null || el.value == "") && (form.elements[or].value==null || form.elements[or].value == "")) {
			var name2 = (hname = form.elements[or].getAttribute("HNAME")) ? hname : form.elements[or].getAttribute("NAME");
			return doError(el,"{name+} 또는 "+name2+" 중 하나는 입력해야 합니다.");
		}
		if (option != null && el.value != "") {
			if (el.getAttribute('SPAN') != null) {
				var _value = new Array();
				for (span=0; span<el.getAttribute('SPAN');span++ ) _value[span] = form.elements[i+span].value;
				var value = _value.join(glue == null ? '' : glue);
				if (!funcs[option](el,value)) return false;
			} else {
				try{
					if (!funcs[option](el)) return false;
				} catch(e) {
					//
				}
			}
		}
	}
	return true;
}

function josa(str,tail) {
	return (str.hasFinalConsonant()) ? tail.substring(0,1) : tail.substring(1,2);
}

function checkMultiBox(el) {
	var obj = document.getElementsByName(el.name);
	for (var i=0; i<obj.length; i++) if(obj[i].checked==true) return true;
	return false;
}

function doError(el,type,action) {
	var _type = $(el).attr("type");
	var pattern = /{([a-zA-Z0-9_]+)\+?([가-힝]{2})?}/;
	var name = (hname = el.getAttribute("HNAME")) ? hname : el.getAttribute("NAME");
	pattern.exec(type);
	if(_type && _type.toLowerCase()=='hidden') {
		alert(type);
	} else {
		// : 이상하게 hidden인 상태에서는 작동을 안하는 현상이 있습니다. 그래서  alert(type); 으로 변경했습니다.
		var tail = (RegExp.$2) ? josa(eval(RegExp.$1),RegExp.$2) : "";
		alert(type.replace(pattern,eval(RegExp.$1) + tail) + SPACE);
	}
	try{
		if (action == "sel") el.select();
		else if (action == "del")	el.value = "";
		if (el.getAttribute("NOFOCUS") == null) el.focus();
		if(el.getAttribute("SETFOCUS") != null && el.getAttribute("SETFOCUS") !='') el.form.elements[el.getAttribute("SETFOCUS")].focus();
		if(_type=='editor') {
			// : cheditor는 어떻게 focus해야하나..
			_editor_use[el.name].editArea.focus();
			//_editor_use[el.name].returnFalse();
		}
	} catch(e){
		return false;
	}

	return false;
}

/// 특수 패턴 검사 함수 매핑 ///
var funcs = new Array();
funcs['domain'] = isValidDomain;
funcs['email'] = isValidEmail;
funcs['hphone'] = isValidHPhone;
funcs['phone'] = isValidPhone;
funcs['tel'] = isValidTel;
funcs['userid'] = isValidUserid;
funcs['userpw'] = isValidUserpw;
funcs['number'] = isNumeric;
funcs['float'] = isFloat;
funcs['engonly'] = alphaOnly;
funcs['jumin'] = isValidJumin;
funcs['bizno'] = isValidBizNo;
funcs['image'] = isValidImage;

/// 패턴 검사 함수들 ///
function isValidDomain(el,value) {
	var value = value ? value : el.value;
	var pattern = /^[_a-zA-Z가-힝0-9-]+\.[a-zA-Z가-힝0-9-\.]+[a-zA-Z]+$/;
	return (pattern.test(value)) ? true : doError(el,NOT_VALID);
}

function isValidEmail(el,value) {
	var value = value ? value : el.value;
	var pattern = /^[_a-zA-Z0-9-\.]+@[\.a-zA-Z0-9-]+\.[a-zA-Z]+$/;
	return (pattern.test(value)) ? true : doError(el,NOT_VALID);
}

function isValidUserid(el) {
	var pattern = /^[a-z]{1}[a-z0-9_]{3,19}$/;
	return (pattern.test(el.value)) ? true : doError(el,"\n죄송합니다. 입력하신 아이디는 입력규칙에 어긋나므로 사용하실 수 없습니다.\n\n{name+은는} 영문자로 시작하는 6~20자의 영문 소문자와 숫자의 조합만 사용할 수 있습니다.");
}

function isValidUserpw(el) {
	//var pattern = /^[a-zA-Z0-9_.]{8,20}$/;
	//var pattern = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,20}$/;
	//var pattern = /^[a-z]{1}[a-z0-9_]{8,20}$/;
	//return (pattern.test(el.value)) ? true : doError(el,"\n죄송합니다. 입력하신 비밀번호는 입력규칙에 어긋나므로 사용하실 수 없습니다."+SPACE+"\n\n{name+은는} 8~20자의 영문, 숫자, 특수문자 조합만 사용할 수 있습니다.");
	if( el.value.length < 8 || el.value.length > 20 ){
		return doError(el,"\n죄송합니다. 입력하신 비밀번호는 입력규칙에 어긋나므로 사용하실 수 없습니다."+SPACE+"\n\n{name+은는} 8~20자의 영문, 숫자, 특수문자 조합만 사용할 수 있습니다.");
	} else {
		return true;
	}
}

function hasHangul(el) {
	var pattern = /[가-힝]/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 한글을 포함해야 합니다.");
}

function alphaOnly(el) {
	var pattern = /^[a-zA-Z]+$/;
	return (pattern.test(el.value)) ? true : doError(el,NOT_VALID);
}

function isNumeric(el) {
	var pattern = /^[0-9]+$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 숫자로만 입력해야 합니다.");
}

function isFloat(el) {
	var pattern = /^[0-9]+(\.[0-9]{1,4})?$/;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 반드시 정수 또는 소수 넷째 자리까지만 입력해야 합니다.");
}

function isValidImage(el) {
	var pattern = /(.+)(gif|jpeg|jpg|png)+$/i;
	return (pattern.test(el.value)) ? true : doError(el,"{name+은는} 이미지 형식만 가능합니다.");
}

function isValidJumin(el,value) {
    var pattern = /^([0-9]{6})-?([0-9]{7})$/; 
	var num = value ? value : el.value;
    if (!pattern.test(num)) return doError(el,NOT_VALID); 
    num = RegExp.$1 + RegExp.$2;

	var sum = 0;
	var last = num.charCodeAt(12) - 0x30;
	var bases = "234567892345";
	for (var i=0; i<12; i++) {
		if (isNaN(num.substring(i,i+1))) return doError(el,NOT_VALID);
		sum += (num.charCodeAt(i) - 0x30) * (bases.charCodeAt(i) - 0x30);
	}
	var mod = sum % 11;
	return ((11 - mod) % 10 == last) ? true : doError(el,NOT_VALID);

	/* 상위 계산방식에 걸리는 주민등록번호가 있을 경우에 아래와 같이 처리
	var num = value ? value : el.value;
	num = num.replace(/[^0-9]/g,'');
	num = num.substr(0,13);
	if(num.length<13) doError(el, NOT_VALID);
	else {
		num = num.replace(/([0-9]{6})([0-9]{7}$)/,"$1-$2"); 
		el.value = num;
		return true;
	}
	*/
}

function isValidBizNo(el, value) { 
    var pattern = /([0-9]{3})-?([0-9]{2})-?([0-9]{5})/; 
	var bizID = value ? value : el.value;
    if (!pattern.test(bizID)) return doError(el,NOT_VALID); 
    bizID = RegExp.$1 + RegExp.$2 + RegExp.$3;
	var checkID = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5, 1);
	var i, Sum=0, c2, remander;
	for (i=0; i<=7; i++) Sum += checkID[i] * bizID.charAt(i);

	c2 = "0" + (checkID[8] * bizID.charAt(8));
	c2 = c2.substring(c2.length - 2, c2.length);
	Sum += Math.floor(c2.charAt(0)) + Math.floor(c2.charAt(1));
	remander = (10 - (Sum % 10)) % 10 ;
	if (Math.floor(bizID.charAt(9)) != remander) {
		return doError(el,NOT_VALID);
	}else{
		return true;
	}

}

function isValidPhone(el,value) {
	var pattern = /^([0]{1}[0-9]{1,2})-?([1-9]{1}[0-9]{2,3})-?([0-9]{4})$/;
	var num = value ? value : el.value;
	if (pattern.exec(num)) {				// 2007-09-30 전화번호 추가(03, 067) by 이창우
		var phones = new Array("020","021","022","023","024","025","026","027","028","029","030","034","035","036","037","038","039","02","03","031","032","033","041","042","043","044","051","052","053","054","055","061","062","063","064","067", "070", "060");
		if(in_array(RegExp.$1, phones, false)) {
			if(!el.getAttribute('SPAN')) el.value = RegExp.$1 + "-" + RegExp.$2 + "-" + RegExp.$3;
			return true;
		}
	}
	return doError(el,NOT_VALID);
}

function isValidHPhone(el,value, flag) {
	var pattern = /^([0]{1}[0-9]{1,2})-?([1-9]{1}[0-9]{2,3})-?([0-9]{4})$/;
	var num = value ? value : el.value;
	if (pattern.exec(num)) {
		var hphones = new Array("011","016","017","018","019","010", "070", "060");
		if(in_array(RegExp.$1, hphones, false)) {
			if(!el.getAttribute('SPAN')) el.value = RegExp.$1 + "-" + RegExp.$2 + "-" + RegExp.$3;
			return true;
		}
	}
	if(flag)
		return false;
	else
		return doError(el,NOT_VALID);
}

function isValidTel(el, value){
	
	var result = false;
	var result2 = false;
	var pattern = /^([0]{1}[0-9]{1,2})-?([1-9]{1}[0-9]{2,3})-?([0-9]{4})$/;
	try{
	var num = value ? value : el.value;
	} catch(e){
		alert(e.message);
	}
	if (pattern.exec(num)) {
		var hphones = new Array("011","016","017","018","019","010", "070", "060");
		if(in_array(RegExp.$1, hphones, false)) {
			if(!el.getAttribute('SPAN')) el.value = RegExp.$1 + "-" + RegExp.$2 + "-" + RegExp.$3;
			return true
		}
	}
	
	if(!result) {
		var pattern = /^([0]{1}[0-9]{1,2})-?([1-9]{1}[0-9]{2,3})-?([0-9]{4})$/;
		var num = value ? value : el.value;
		if (pattern.exec(num)) {				// 2007-09-30 전화번호 추가(03, 067) by 이창우
			var phones = new Array("020","021","022","023","024","025","026","027","028","029","030","034","035","036","037","038","039","02","03","031","032","033","041","042","043","044","051","052","053","054","055","061","062","063","064","067", "070", "060");
			if(in_array(RegExp.$1, phones, false)) {
				if(!el.getAttribute('SPAN')) el.value = RegExp.$1 + "-" + RegExp.$2 + "-" + RegExp.$3;
				return true;
			}
		}
	}

	
	return doError(el,NOT_VALID);	

}