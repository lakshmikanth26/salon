! function(t, e) {
    "object" == typeof exports && "object" == typeof module ? module.exports = e(require("moment"), require("jquery")) : "function" == typeof define && define.amd ? define(["moment", "jquery"], e) : "object" == typeof exports ? exports.FullCalendar = e(require("moment"), require("jquery")) : t.FullCalendar = e(t.moment, t.jQuery)
}("undefined" != typeof self ? self : this, function(n, i) {
    return function(n) {
        var i = {};

        function r(t) {
            if (i[t]) return i[t].exports;
            var e = i[t] = {
                i: t,
                l: !1,
                exports: {}
            };
            return n[t].call(e.exports, e, e.exports, r), e.l = !0, e.exports
        }
        return r.m = n, r.c = i, r.d = function(t, e, n) {
            r.o(t, e) || Object.defineProperty(t, e, {
                configurable: !1,
                enumerable: !0,
                get: n
            })
        }, r.n = function(t) {
            var e = t && t.__esModule ? function() {
                return t.default
            } : function() {
                return t
            };
            return r.d(e, "a", e), e
        }, r.o = function(t, e) {
            return Object.prototype.hasOwnProperty.call(t, e)
        }, r.p = "", r(r.s = 236)
    }([function(t, e) {
        t.exports = n
    }, , function(t, e) {
        var i = Object.setPrototypeOf || {
            __proto__: []
        }
        instanceof Array && function(t, e) {
            t.__proto__ = e
        } || function(t, e) {
            for (var n in e) e.hasOwnProperty(n) && (t[n] = e[n])
        };
        e.__extends = function(t, e) {
            function n() {
                this.constructor = t
            }
            i(t, e), t.prototype = null === e ? Object.create(e) : (n.prototype = e.prototype, new n)
        }
    }, function(t, e) {
        t.exports = i
    }, function(t, o, e) {
        Object.defineProperty(o, "__esModule", {
            value: !0
        });
        var i = e(0),
            c = e(3);

        function n(t) {
            t.height("")
        }

        function s(t) {
            var e, n = t[0].offsetWidth - t[0].clientWidth,
                i = t[0].offsetHeight - t[0].clientHeight;
            return n = r(n), e = {
                left: 0,
                right: 0,
                top: 0,
                bottom: i = r(i)
            }, ! function() {
                null === a && (t = c("<div><div/></div>").css({
                    position: "absolute",
                    top: -1e3,
                    left: 0,
                    border: 0,
                    padding: 0,
                    overflow: "scroll",
                    direction: "rtl"
                }).appendTo("body"), e = t.children().offset().left > t.offset().left, t.remove(), a = e);
                var t, e;
                return a
            }() || "rtl" !== t.css("direction") ? e.right = n : e.left = n, e
        }

        function r(t) {
            return t = Math.max(0, t), t = Math.round(t)
        }
        o.compensateScroll = function(t, e) {
            e.left && t.css({
                "border-left-width": 1,
                "margin-left": e.left - 1
            }), e.right && t.css({
                "border-right-width": 1,
                "margin-right": e.right - 1
            })
        }, o.uncompensateScroll = function(t) {
            t.css({
                "margin-left": "",
                "margin-right": "",
                "border-left-width": "",
                "border-right-width": ""
            })
        }, o.disableCursor = function() {
            c("body").addClass("fc-not-allowed")
        }, o.enableCursor = function() {
            c("body").removeClass("fc-not-allowed")
        }, o.distributeHeight = function(r, t, e) {
            var o = Math.floor(t / r.length),
                s = Math.floor(t - o * (r.length - 1)),
                a = [],
                l = [],
                u = [],
                d = 0;
            n(r), r.each(function(t, e) {
                var n = t === r.length - 1 ? s : o,
                    i = c(e).outerHeight(!0);
                i < n ? (a.push(e), l.push(i), u.push(c(e).height())) : d += i
            }), e && (t -= d, o = Math.floor(t / a.length), s = Math.floor(t - o * (a.length - 1))), c(a).each(function(t, e) {
                var n = t === a.length - 1 ? s : o,
                    i = l[t],
                    r = n - (i - u[t]);
                i < n && c(e).height(r)
            })
        }, o.undistributeHeight = n, o.matchCellWidths = function(t) {
            var i = 0;
            return t.find("> *").each(function(t, e) {
                var n = c(e).outerWidth();
                i < n && (i = n)
            }), i++, t.width(i), i
        }, o.subtractInnerElHeight = function(t, e) {
            var n, i = t.add(e);
            return i.css({
                position: "relative",
                left: -1
            }), n = t.outerHeight() - e.outerHeight(), i.css({
                position: "",
                left: ""
            }), n
        }, o.getScrollParent = function(t) {
            var e = t.css("position"),
                n = t.parents().filter(function() {
                    var t = c(this);
                    return /(auto|scroll)/.test(t.css("overflow") + t.css("overflow-y") + t.css("overflow-x"))
                }).eq(0);
            return "fixed" !== e && n.length ? n : c(t[0].ownerDocument || document)
        }, o.getOuterRect = function(t, e) {
            var n = t.offset(),
                i = n.left - (e ? e.left : 0),
                r = n.top - (e ? e.top : 0);
            return {
                left: i,
                right: i + t.outerWidth(),
                top: r,
                bottom: r + t.outerHeight()
            }
        }, o.getClientRect = function(t, e) {
            var n = t.offset(),
                i = s(t),
                r = n.left + l(t, "border-left-width") + i.left - (e ? e.left : 0),
                o = n.top + l(t, "border-top-width") + i.top - (e ? e.top : 0);
            return {
                left: r,
                right: r + t[0].clientWidth,
                top: o,
                bottom: o + t[0].clientHeight
            }
        }, o.getContentRect = function(t, e) {
            var n = t.offset(),
                i = n.left + l(t, "border-left-width") + l(t, "padding-left") - (e ? e.left : 0),
                r = n.top + l(t, "border-top-width") + l(t, "padding-top") - (e ? e.top : 0);
            return {
                left: i,
                right: i + t.width(),
                top: r,
                bottom: r + t.height()
            }
        }, o.getScrollbarWidths = s;
        var a = null;

        function l(t, e) {
            return parseFloat(t.css(e)) || 0
        }

        function u(t) {
            t.preventDefault()
        }

        function d(t, e, n, i, r) {
            if (n.func) return n.func(t, e);
            var o = t[n.field],
                s = e[n.field];
            return null == o && i && (o = i[n.field]), null == s && r && (s = r[n.field]), p(o, s) * (n.order || 1)
        }

        function p(t, e) {
            return t || e ? null == e ? -1 : null == t ? 1 : "string" === c.type(t) || "string" === c.type(e) ? String(t).localeCompare(String(e)) : t - e : 0
        }

        function h(t, e) {
            var n, i, r;
            for (n = 0; n < o.unitsDesc.length && !(1 <= (r = f(i = o.unitsDesc[n], t, e)) && w(r)); n++);
            return i
        }

        function f(t, e, n) {
            return null != n ? n.diff(e, t, !0) : i.isDuration(e) ? e.as(t) : e.end.diff(e.start, t, !0)
        }

        function g(t) {
            return Boolean(t.hours() || t.minutes() || t.seconds() || t.milliseconds())
        }

        function v() {
            for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e];
            var n = window.console;
            if (n && n.log) return n.log.apply(n, t)
        }
        o.isPrimaryMouseButton = function(t) {
            return 1 === t.which && !t.ctrlKey
        }, o.getEvX = function(t) {
            var e = t.originalEvent.touches;
            return e && e.length ? e[0].pageX : t.pageX
        }, o.getEvY = function(t) {
            var e = t.originalEvent.touches;
            return e && e.length ? e[0].pageY : t.pageY
        }, o.getEvIsTouch = function(t) {
            return /^touch/.test(t.type)
        }, o.preventSelection = function(t) {
            t.addClass("fc-unselectable").on("selectstart", u)
        }, o.allowSelection = function(t) {
            t.removeClass("fc-unselectable").off("selectstart", u)
        }, o.preventDefault = u, o.intersectRects = function(t, e) {
            var n = {
                left: Math.max(t.left, e.left),
                right: Math.min(t.right, e.right),
                top: Math.max(t.top, e.top),
                bottom: Math.min(t.bottom, e.bottom)
            };
            return n.left < n.right && n.top < n.bottom && n
        }, o.constrainPoint = function(t, e) {
            return {
                left: Math.min(Math.max(t.left, e.left), e.right),
                top: Math.min(Math.max(t.top, e.top), e.bottom)
            }
        }, o.getRectCenter = function(t) {
            return {
                left: (t.left + t.right) / 2,
                top: (t.top + t.bottom) / 2
            }
        }, o.diffPoints = function(t, e) {
            return {
                left: t.left - e.left,
                top: t.top - e.top
            }
        }, o.parseFieldSpecs = function(t) {
            var e, n, i = [],
                r = [];
            for ("string" == typeof t ? r = t.split(/\s*,\s*/) : "function" == typeof t ? r = [t] : c.isArray(t) && (r = t), e = 0; e < r.length; e++) "string" == typeof(n = r[e]) ? i.push("-" === n.charAt(0) ? {
                field: n.substring(1),
                order: -1
            } : {
                field: n,
                order: 1
            }) : "function" == typeof n && i.push({
                func: n
            });
            return i
        }, o.compareByFieldSpecs = function(t, e, n, i, r) {
            var o, s;
            for (o = 0; o < n.length; o++)
                if (s = d(t, e, n[o], i, r)) return s;
            return 0
        }, o.compareByFieldSpec = d, o.flexibleCompare = p, o.dayIDs = ["sun", "mon", "tue", "wed", "thu", "fri", "sat"], o.unitsDesc = ["year", "month", "week", "day", "hour", "minute", "second", "millisecond"], o.diffDayTime = function(t, e) {
            return i.duration({
                days: t.clone().stripTime().diff(e.clone().stripTime(), "days"),
                ms: t.time() - e.time()
            })
        }, o.diffDay = function(t, e) {
            return i.duration({
                days: t.clone().stripTime().diff(e.clone().stripTime(), "days")
            })
        }, o.diffByUnit = function(t, e, n) {
            return i.duration(Math.round(t.diff(e, n, !0)), n)
        }, o.computeGreatestUnit = h, o.computeDurationGreatestUnit = function(t, e) {
            var n = h(t);
            return "week" === n && "object" == typeof e && e.days && (n = "day"), n
        }, o.divideRangeByDuration = function(t, e, n) {
            var i;
            return g(n) ? (e - t) / n : (i = n.asMonths(), 1 <= Math.abs(i) && w(i) ? e.diff(t, "months", !0) / i : e.diff(t, "days", !0) / n.asDays())
        }, o.divideDurationByDuration = function(t, e) {
            var n, i;
            return g(t) || g(e) ? t / e : (n = t.asMonths(), i = e.asMonths(), 1 <= Math.abs(n) && w(n) && 1 <= Math.abs(i) && w(i) ? n / i : t.asDays() / e.asDays())
        }, o.multiplyDuration = function(t, e) {
            var n;
            return g(t) ? i.duration(t * e) : (n = t.asMonths(), 1 <= Math.abs(n) && w(n) ? i.duration({
                months: n * e
            }) : i.duration({
                days: t.asDays() * e
            }))
        }, o.durationHasTime = g, o.isNativeDate = function(t) {
            return "[object Date]" === Object.prototype.toString.call(t) || t instanceof Date
        }, o.isTimeString = function(t) {
            return "string" == typeof t && /^\d+\:\d+(?:\:\d+\.?(?:\d{3})?)?$/.test(t)
        }, o.log = v, o.warn = function() {
            for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e];
            var n = window.console;
            return n && n.warn ? n.warn.apply(n, t) : v.apply(null, t)
        };
        var y = {}.hasOwnProperty;

        function m(t, e) {
            return y.call(t, e)
        }

        function b(t) {
            return (t + "").replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&#039;").replace(/"/g, "&quot;").replace(/\n/g, "<br />")
        }

        function w(t) {
            return t % 1 == 0
        }
        o.mergeProps = function t(e, n) {
            var i, r, o, s, a, l, u = {};
            if (n)
                for (i = 0; i < n.length; i++) {
                    for (r = n[i], o = [], s = e.length - 1; 0 <= s; s--)
                        if ("object" == typeof(a = e[s][r])) o.unshift(a);
                        else if (void 0 !== a) {
                        u[r] = a;
                        break
                    }
                    o.length && (u[r] = t(o))
                }
            for (i = e.length - 1; 0 <= i; i--)
                for (r in l = e[i]) r in u || (u[r] = l[r]);
            return u
        }, o.copyOwnProps = function(t, e) {
            for (var n in t) m(t, n) && (e[n] = t[n])
        }, o.hasOwnProp = m, o.applyAll = function(t, e, n) {
            if (c.isFunction(t) && (t = [t]), t) {
                var i = void 0,
                    r = void 0;
                for (i = 0; i < t.length; i++) r = t[i].apply(e, n) || r;
                return r
            }
        }, o.removeMatching = function(t, e) {
            for (var n = 0, i = 0; i < t.length;) e(t[i]) ? (t.splice(i, 1), n++) : i++;
            return n
        }, o.removeExact = function(t, e) {
            for (var n = 0, i = 0; i < t.length;) t[i] === e ? (t.splice(i, 1), n++) : i++;
            return n
        }, o.isArraysEqual = function(t, e) {
            var n, i = t.length;
            if (null == i || i !== e.length) return !1;
            for (n = 0; n < i; n++)
                if (t[n] !== e[n]) return !1;
            return !0
        }, o.firstDefined = function() {
            for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e];
            for (var n = 0; n < t.length; n++)
                if (void 0 !== t[n]) return t[n]
        }, o.htmlEscape = b, o.stripHtmlEntities = function(t) {
            return t.replace(/&.*?;/g, "")
        }, o.cssToStr = function(t) {
            var n = [];
            return c.each(t, function(t, e) {
                null != e && n.push(t + ":" + e)
            }), n.join(";")
        }, o.attrsToStr = function(t) {
            var n = [];
            return c.each(t, function(t, e) {
                null != e && n.push(t + '="' + b(e) + '"')
            }), n.join(" ")
        }, o.capitaliseFirstLetter = function(t) {
            return t.charAt(0).toUpperCase() + t.slice(1)
        }, o.compareNumbers = function(t, e) {
            return t - e
        }, o.isInt = w, o.proxy = function(t, e) {
            var n = t[e];
            return function() {
                return n.apply(t, arguments)
            }
        }, o.debounce = function(e, n, i) {
            var r, o, s, a, l;
            void 0 === i && (i = !1);
            var u = function() {
                var t = +new Date - a;
                t < n ? r = setTimeout(u, n - t) : (r = null, i || (l = e.apply(s, o), s = o = null))
            };
            return function() {
                s = this, o = arguments, a = +new Date;
                var t = i && !r;
                return r || (r = setTimeout(u, n)), t && (l = e.apply(s, o), s = o = null), l
            }
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(0),
            r = n(10),
            o = function() {
                function s(t, e) {
                    this.isStart = !0, this.isEnd = !0, i.isMoment(t) && (t = t.clone().stripZone()), i.isMoment(e) && (e = e.clone().stripZone()), t && (this.startMs = t.valueOf()), e && (this.endMs = e.valueOf())
                }
                return s.invertRanges = function(t, e) {
                    var n, i, r = [],
                        o = e.startMs;
                    for (t.sort(a), n = 0; n < t.length; n++)(i = t[n]).startMs > o && r.push(new s(o, i.startMs)), i.endMs > o && (o = i.endMs);
                    return o < e.endMs && r.push(new s(o, e.endMs)), r
                }, s.prototype.intersect = function(t) {
                    var e = this.startMs,
                        n = this.endMs,
                        i = null;
                    return null != t.startMs && (e = null == e ? t.startMs : Math.max(e, t.startMs)), null != t.endMs && (n = null == n ? t.endMs : Math.min(n, t.endMs)), (null == e || null == n || e < n) && ((i = new s(e, n)).isStart = this.isStart && e === this.startMs, i.isEnd = this.isEnd && n === this.endMs), i
                }, s.prototype.intersectsWith = function(t) {
                    return (null == this.endMs || null == t.startMs || this.endMs > t.startMs) && (null == this.startMs || null == t.endMs || this.startMs < t.endMs)
                }, s.prototype.containsRange = function(t) {
                    return (null == this.startMs || null != t.startMs && t.startMs >= this.startMs) && (null == this.endMs || null != t.endMs && t.endMs <= this.endMs)
                }, s.prototype.containsDate = function(t) {
                    var e = t.valueOf();
                    return (null == this.startMs || e >= this.startMs) && (null == this.endMs || e < this.endMs)
                }, s.prototype.constrainDate = function(t) {
                    var e = t.valueOf();
                    return null != this.startMs && e < this.startMs && (e = this.startMs), null != this.endMs && e >= this.endMs && (e = this.endMs - 1), e
                }, s.prototype.equals = function(t) {
                    return this.startMs === t.startMs && this.endMs === t.endMs
                }, s.prototype.clone = function() {
                    var t = new s(this.startMs, this.endMs);
                    return t.isStart = this.isStart, t.isEnd = this.isEnd, t
                }, s.prototype.getStart = function() {
                    return null != this.startMs ? r.default.utc(this.startMs).stripZone() : null
                }, s.prototype.getEnd = function() {
                    return null != this.endMs ? r.default.utc(this.endMs).stripZone() : null
                }, s.prototype.as = function(t) {
                    return i.utc(this.endMs).diff(i.utc(this.startMs), t, !0)
                }, s
            }();

        function a(t, e) {
            return t.startMs - e.startMs
        }
        e.default = o
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            o = n(3),
            s = n(208),
            i = n(33),
            a = n(49),
            l = function(n) {
                function i(t) {
                    var e = n.call(this) || this;
                    return e.calendar = t, e.className = [], e.uid = String(i.uuid++), e
                }
                return r.__extends(i, n), i.parse = function(t, e) {
                    var n = new this(e);
                    return !("object" != typeof t || !n.applyProps(t)) && n
                }, i.normalizeId = function(t) {
                    return t ? String(t) : null
                }, i.prototype.fetch = function(t, e, n) {}, i.prototype.removeEventDefsById = function(t) {}, i.prototype.removeAllEventDefs = function() {}, i.prototype.getPrimitive = function(t) {}, i.prototype.parseEventDefs = function(t) {
                    var e, n, i = [];
                    for (e = 0; e < t.length; e++)(n = this.parseEventDef(t[e])) && i.push(n);
                    return i
                }, i.prototype.parseEventDef = function(t) {
                    var e = this.calendar.opt("eventDataTransform"),
                        n = this.eventDataTransform;
                    return e && (t = e(t, this.calendar)), n && (t = n(t, this.calendar)), a.default.parse(t, this)
                }, i.prototype.applyManualStandardProps = function(t) {
                    return null != t.id && (this.id = i.normalizeId(t.id)), o.isArray(t.className) ? this.className = t.className : "string" == typeof t.className && (this.className = t.className.split(/\s+/)), !0
                }, i.uuid = 0, i.defineStandardProps = s.default.defineStandardProps, i.copyVerbatimStandardProps = s.default.copyVerbatimStandardProps, i
            }(i.default);
        e.default = l, s.default.mixInto(l), l.defineStandardProps({
            id: !1,
            className: !1,
            color: !0,
            backgroundColor: !0,
            borderColor: !0,
            textColor: !0,
            editable: !0,
            startEditable: !0,
            durationEditable: !0,
            rendering: !0,
            overlap: !0,
            constraint: !0,
            allDayDefault: !0,
            eventDataTransform: !0
        })
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(3),
            o = n(14),
            s = 0,
            a = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.listenTo = function(t, e, n) {
                    if ("object" == typeof e)
                        for (var i in e) e.hasOwnProperty(i) && this.listenTo(t, i, e[i]);
                    else "string" == typeof e && t.on(e + "." + this.getListenerNamespace(), r.proxy(n, this))
                }, e.prototype.stopListeningTo = function(t, e) {
                    t.off((e || "") + "." + this.getListenerNamespace())
                }, e.prototype.getListenerNamespace = function() {
                    return null == this.listenerId && (this.listenerId = s++), "_listener" + this.listenerId
                }, e
            }(o.default);
        e.default = a
    }, , , function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var u = n(0),
            d = n(3),
            c = n(4),
            p = /^\s*\d{4}-\d\d$/,
            h = /^\s*\d{4}-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?)?$/,
            i = u.fn;
        e.newMomentProto = i;
        var r = d.extend({}, i);
        e.oldMomentProto = r;
        var o = u.momentProperties;
        o.push("_fullCalendar"), o.push("_ambigTime"), o.push("_ambigZone"), e.oldMomentFormat = function(t, e) {
            return r.format.call(t, e)
        };
        var s = function() {
            return a(arguments)
        };

        function a(t, e, n) {
            void 0 === e && (e = !1), void 0 === n && (n = !1);
            var i, r, o, s, a = t[0],
                l = 1 === t.length && "string" == typeof a;
            return u.isMoment(a) || c.isNativeDate(a) || void 0 === a ? s = u.apply(null, t) : (r = i = !1, l ? p.test(a) ? (t = [a += "-01"], r = i = !0) : (o = h.exec(a)) && (i = !o[5], r = !0) : d.isArray(a) && (r = !0), s = e || i ? u.utc.apply(u, t) : u.apply(null, t), i ? (s._ambigTime = !0, s._ambigZone = !0) : n && (r ? s._ambigZone = !0 : l && s.utcOffset(a))), s._fullCalendar = !0, s
        }(e.default = s).utc = function() {
            var t = a(arguments, !0);
            return t.hasTime() && t.utc(), t
        }, s.parseZone = function() {
            return a(arguments, !0, !0)
        }, i.week = i.weeks = function(t) {
            var e = this._locale._fullCalendar_weekCalc;
            return null == t && "function" == typeof e ? e(this) : "ISO" === e ? r.isoWeek.apply(this, arguments) : r.week.apply(this, arguments)
        }, i.time = function(t) {
            if (!this._fullCalendar) return r.time.apply(this, arguments);
            if (null == t) return u.duration({
                hours: this.hours(),
                minutes: this.minutes(),
                seconds: this.seconds(),
                milliseconds: this.milliseconds()
            });
            this._ambigTime = !1, u.isDuration(t) || u.isMoment(t) || (t = u.duration(t));
            var e = 0;
            return u.isDuration(t) && (e = 24 * Math.floor(t.asDays())), this.hours(e + t.hours()).minutes(t.minutes()).seconds(t.seconds()).milliseconds(t.milliseconds())
        }, i.stripTime = function() {
            return this._ambigTime || (this.utc(!0), this.set({
                hours: 0,
                minutes: 0,
                seconds: 0,
                ms: 0
            }), this._ambigTime = !0, this._ambigZone = !0), this
        }, i.hasTime = function() {
            return !this._ambigTime
        }, i.stripZone = function() {
            var t;
            return this._ambigZone || (t = this._ambigTime, this.utc(!0), this._ambigTime = t || !1, this._ambigZone = !0), this
        }, i.hasZone = function() {
            return !this._ambigZone
        }, i.local = function(t) {
            return r.local.call(this, this._ambigZone || t), this._ambigTime = !1, this._ambigZone = !1, this
        }, i.utc = function(t) {
            return r.utc.call(this, t), this._ambigTime = !1, this._ambigZone = !1, this
        }, i.utcOffset = function(t) {
            return null != t && (this._ambigTime = !1, this._ambigZone = !1), r.utcOffset.apply(this, arguments)
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(3),
            o = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.on = function(t, e) {
                    return r(this).on(t, this._prepareIntercept(e)), this
                }, e.prototype.one = function(t, e) {
                    return r(this).one(t, this._prepareIntercept(e)), this
                }, e.prototype._prepareIntercept = function(n) {
                    var t = function(t, e) {
                        return n.apply(e.context || this, e.args || [])
                    };
                    return n.guid || (n.guid = r.guid++), t.guid = n.guid, t
                }, e.prototype.off = function(t, e) {
                    return r(this).off(t, e), this
                }, e.prototype.trigger = function(t) {
                    for (var e = [], n = 1; n < arguments.length; n++) e[n - 1] = arguments[n];
                    return r(this).triggerHandler(t, {
                        args: e
                    }), this
                }, e.prototype.triggerWith = function(t, e, n) {
                    return r(this).triggerHandler(t, {
                        context: e,
                        args: n
                    }), this
                }, e.prototype.hasHandlers = function(t) {
                    var e = r._data(this, "events");
                    return e && e[t] && 0 < e[t].length
                }, e
            }(n(14).default);
        e.default = o
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function() {
            function t(t, e) {
                this.isAllDay = !1, this.unzonedRange = t, this.isAllDay = e
            }
            return t.prototype.toLegacy = function(t) {
                return {
                    start: t.msToMoment(this.unzonedRange.startMs, this.isAllDay),
                    end: t.msToMoment(this.unzonedRange.endMs, this.isAllDay)
                }
            }, t
        }();
        e.default = n
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            i = n(34),
            o = n(209),
            s = n(17),
            a = function(i) {
                function t() {
                    return null !== i && i.apply(this, arguments) || this
                }
                return r.__extends(t, i), t.prototype.buildInstances = function() {
                    return [this.buildInstance()]
                }, t.prototype.buildInstance = function() {
                    return new o.default(this, this.dateProfile)
                }, t.prototype.isAllDay = function() {
                    return this.dateProfile.isAllDay()
                }, t.prototype.clone = function() {
                    var t = i.prototype.clone.call(this);
                    return t.dateProfile = this.dateProfile, t
                }, t.prototype.rezone = function() {
                    var t = this.source.calendar,
                        e = this.dateProfile;
                    this.dateProfile = new s.default(t.moment(e.start), e.end ? t.moment(e.end) : null, t)
                }, t.prototype.applyManualStandardProps = function(t) {
                    var e = i.prototype.applyManualStandardProps.call(this, t),
                        n = s.default.parse(t, this.source);
                    return !!n && (this.dateProfile = n, null != t.date && (this.miscProps.date = t.date), e)
                }, t
            }(i.default);
        (e.default = a).defineStandardProps({
            start: !1,
            date: !1,
            end: !1,
            allDay: !1
        })
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function() {
            function t() {}
            return t.mixInto = function(e) {
                var n = this;
                Object.getOwnPropertyNames(this.prototype).forEach(function(t) {
                    e.prototype[t] || (e.prototype[t] = n.prototype[t])
                })
            }, t.mixOver = function(e) {
                var n = this;
                Object.getOwnPropertyNames(this.prototype).forEach(function(t) {
                    e.prototype[t] = n.prototype[t]
                })
            }, t
        }();
        e.default = n
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function() {
            function t(t) {
                this.view = t._getView(), this.component = t
            }
            return t.prototype.opt = function(t) {
                return this.view.opt(t)
            }, t.prototype.end = function() {}, t
        }();
        e.default = n
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        }), e.version = "3.9.0", e.internalApiVersion = 12;
        var i = n(4);
        e.applyAll = i.applyAll, e.debounce = i.debounce, e.isInt = i.isInt, e.htmlEscape = i.htmlEscape, e.cssToStr = i.cssToStr, e.proxy = i.proxy, e.capitaliseFirstLetter = i.capitaliseFirstLetter, e.getOuterRect = i.getOuterRect, e.getClientRect = i.getClientRect, e.getContentRect = i.getContentRect, e.getScrollbarWidths = i.getScrollbarWidths, e.preventDefault = i.preventDefault, e.parseFieldSpecs = i.parseFieldSpecs, e.compareByFieldSpecs = i.compareByFieldSpecs, e.compareByFieldSpec = i.compareByFieldSpec, e.flexibleCompare = i.flexibleCompare, e.computeGreatestUnit = i.computeGreatestUnit, e.divideRangeByDuration = i.divideRangeByDuration, e.divideDurationByDuration = i.divideDurationByDuration, e.multiplyDuration = i.multiplyDuration, e.durationHasTime = i.durationHasTime, e.log = i.log, e.warn = i.warn, e.removeExact = i.removeExact, e.intersectRects = i.intersectRects;
        var r = n(47);
        e.formatDate = r.formatDate, e.formatRange = r.formatRange, e.queryMostGranularFormatUnit = r.queryMostGranularFormatUnit;
        var o = n(31);
        e.datepickerLocale = o.datepickerLocale, e.locale = o.locale;
        var s = n(10);
        e.moment = s.default;
        var a = n(11);
        e.EmitterMixin = a.default;
        var l = n(7);
        e.ListenerMixin = l.default;
        var u = n(48);
        e.Model = u.default;
        var d = n(207);
        e.Constraints = d.default;
        var c = n(5);
        e.UnzonedRange = c.default;
        var p = n(12);
        e.ComponentFootprint = p.default;
        var h = n(212);
        e.BusinessHourGenerator = h.default;
        var f = n(34);
        e.EventDef = f.default;
        var g = n(37);
        e.EventDefMutation = g.default;
        var v = n(38);
        e.EventSourceParser = v.default;
        var y = n(6);
        e.EventSource = y.default;
        var m = n(51);
        e.defineThemeSystem = m.defineThemeSystem;
        var b = n(18);
        e.EventInstanceGroup = b.default;
        var w = n(52);
        e.ArrayEventSource = w.default;
        var D = n(215);
        e.FuncEventSource = D.default;
        var E = n(216);
        e.JsonFeedEventSource = E.default;
        var S = n(36);
        e.EventFootprint = S.default;
        var C = n(33);
        e.Class = C.default;
        var R = n(14);
        e.Mixin = R.default;
        var T = n(53);
        e.CoordCache = T.default;
        var M = n(54);
        e.DragListener = M.default;
        var I = n(20);
        e.Promise = I.default;
        var H = n(217);
        e.TaskQueue = H.default;
        var P = n(218);
        e.RenderQueue = P.default;
        var _ = n(39);
        e.Scroller = _.default;
        var x = n(19);
        e.Theme = x.default;
        var O = n(219);
        e.DateComponent = O.default;
        var F = n(40);
        e.InteractiveDateComponent = F.default;
        var z = n(220);
        e.Calendar = z.default;
        var B = n(41);
        e.View = B.default;
        var A = n(22);
        e.defineView = A.defineView, e.getViewConfig = A.getViewConfig;
        var k = n(55);
        e.DayTableMixin = k.default;
        var L = n(56);
        e.BusinessHourRenderer = L.default;
        var V = n(42);
        e.EventRenderer = V.default;
        var G = n(57);
        e.FillRenderer = G.default;
        var N = n(58);
        e.HelperRenderer = N.default;
        var j = n(222);
        e.ExternalDropping = j.default;
        var U = n(223);
        e.EventResizing = U.default;
        var W = n(59);
        e.EventPointing = W.default;
        var q = n(224);
        e.EventDragging = q.default;
        var Y = n(225);
        e.DateSelecting = Y.default;
        var Z = n(60);
        e.StandardInteractionsMixin = Z.default;
        var Q = n(226);
        e.AgendaView = Q.default;
        var X = n(227);
        e.TimeGrid = X.default;
        var $ = n(61);
        e.DayGrid = $.default;
        var K = n(62);
        e.BasicView = K.default;
        var J = n(229);
        e.MonthView = J.default;
        var tt = n(230);
        e.ListView = tt.default
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(5),
            r = function() {
                function u(t, e, n) {
                    this.start = t, this.end = e || null, this.unzonedRange = this.buildUnzonedRange(n)
                }
                return u.parse = function(t, e) {
                    var n = t.start || t.date,
                        i = t.end;
                    if (!n) return !1;
                    var r = e.calendar,
                        o = r.moment(n),
                        s = i ? r.moment(i) : null,
                        a = t.allDay,
                        l = r.opt("forceEventDuration");
                    return !!o.isValid() && (!s || s.isValid() && s.isAfter(o) || (s = null), null == a && null == (a = e.allDayDefault) && (a = r.opt("allDayDefault")), !0 === a ? (o.stripTime(), s && s.stripTime()) : !1 === a && (o.hasTime() || o.time(0), s && !s.hasTime() && s.time(0)), !s && l && (s = r.getDefaultEventEnd(!o.hasTime(), o)), new u(o, s, r))
                }, u.isStandardProp = function(t) {
                    return "start" === t || "date" === t || "end" === t || "allDay" === t
                }, u.prototype.isAllDay = function() {
                    return !(this.start.hasTime() || this.end && this.end.hasTime())
                }, u.prototype.buildUnzonedRange = function(t) {
                    var e = this.start.clone().stripZone().valueOf(),
                        n = this.getEnd(t).stripZone().valueOf();
                    return new i.default(e, n)
                }, u.prototype.getEnd = function(t) {
                    return this.end ? this.end.clone() : t.getDefaultEventEnd(this.isAllDay(), this.start)
                }, u
            }();
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(5),
            r = n(35),
            s = n(211),
            o = function() {
                function t(t) {
                    this.eventInstances = t || []
                }
                return t.prototype.getAllEventRanges = function(t) {
                    return t ? this.sliceNormalRenderRanges(t) : this.eventInstances.map(r.eventInstanceToEventRange)
                }, t.prototype.sliceRenderRanges = function(t) {
                    return this.isInverse() ? this.sliceInverseRenderRanges(t) : this.sliceNormalRenderRanges(t)
                }, t.prototype.sliceNormalRenderRanges = function(t) {
                    var e, n, i, r = this.eventInstances,
                        o = [];
                    for (e = 0; e < r.length; e++)(i = (n = r[e]).dateProfile.unzonedRange.intersect(t)) && o.push(new s.default(i, n.def, n));
                    return o
                }, t.prototype.sliceInverseRenderRanges = function(t) {
                    var e = this.eventInstances.map(r.eventInstanceToUnzonedRange),
                        n = this.getEventDef();
                    return (e = i.default.invertRanges(e, t)).map(function(t) {
                        return new s.default(t, n)
                    })
                }, t.prototype.isInverse = function() {
                    return this.getEventDef().hasInverseRendering()
                }, t.prototype.getEventDef = function() {
                    return this.explicitEventDef || this.eventInstances[0].def
                }, t
            }();
        e.default = o
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(3),
            r = function() {
                function t(t) {
                    this.optionsManager = t, this.processIconOverride()
                }
                return t.prototype.processIconOverride = function() {
                    this.iconOverrideOption && this.setIconOverride(this.optionsManager.get(this.iconOverrideOption))
                }, t.prototype.setIconOverride = function(t) {
                    var e, n;
                    if (i.isPlainObject(t)) {
                        for (n in e = i.extend({}, this.iconClasses), t) e[n] = this.applyIconOverridePrefix(t[n]);
                        this.iconClasses = e
                    } else !1 === t && (this.iconClasses = {})
                }, t.prototype.applyIconOverridePrefix = function(t) {
                    var e = this.iconOverridePrefix;
                    return e && 0 !== t.indexOf(e) && (t = e + t), t
                }, t.prototype.getClass = function(t) {
                    return this.classes[t] || ""
                }, t.prototype.getIconClass = function(t) {
                    var e = this.iconClasses[t];
                    return e ? this.baseIconClass + " " + e : ""
                }, t.prototype.getCustomButtonIconClass = function(t) {
                    var e;
                    return this.iconOverrideCustomButtonOption && (e = t[this.iconOverrideCustomButtonOption]) ? this.baseIconClass + " " + this.applyIconOverridePrefix(e) : ""
                }, t
            }();
        (e.default = r).prototype.classes = {}, r.prototype.iconClasses = {}, r.prototype.baseIconClass = "", r.prototype.iconOverridePrefix = ""
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(3),
            r = {
                construct: function(t) {
                    var e = i.Deferred(),
                        n = e.promise();
                    return "function" == typeof t && t(function(t) {
                        e.resolve(t), o(n, t)
                    }, function() {
                        e.reject(), s(n)
                    }), n
                },
                resolve: function(t) {
                    var e = i.Deferred().resolve(t).promise();
                    return o(e, t), e
                },
                reject: function() {
                    var t = i.Deferred().reject().promise();
                    return s(t), t
                }
            };

        function o(e, n) {
            e.then = function(t) {
                return "function" == typeof t ? r.resolve(t(n)) : e
            }
        }

        function s(n) {
            n.then = function(t, e) {
                return "function" == typeof e && e(), n
            }
        }
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(3),
            r = n(16),
            o = n(11),
            s = n(7);
        r.touchMouseIgnoreWait = 500;
        var a = null,
            l = 0,
            u = function() {
                function t() {
                    this.isTouching = !1, this.mouseIgnoreDepth = 0
                }
                return t.get = function() {
                    return a || (a = new t).bind(), a
                }, t.needed = function() {
                    t.get(), l++
                }, t.unneeded = function() {
                    --l || (a.unbind(), a = null)
                }, t.prototype.bind = function() {
                    var e = this;
                    this.listenTo(i(document), {
                        touchstart: this.handleTouchStart,
                        touchcancel: this.handleTouchCancel,
                        touchend: this.handleTouchEnd,
                        mousedown: this.handleMouseDown,
                        mousemove: this.handleMouseMove,
                        mouseup: this.handleMouseUp,
                        click: this.handleClick,
                        selectstart: this.handleSelectStart,
                        contextmenu: this.handleContextMenu
                    }), window.addEventListener("touchmove", this.handleTouchMoveProxy = function(t) {
                        e.handleTouchMove(i.Event(t))
                    }, {
                        passive: !1
                    }), window.addEventListener("scroll", this.handleScrollProxy = function(t) {
                        e.handleScroll(i.Event(t))
                    }, !0)
                }, t.prototype.unbind = function() {
                    this.stopListeningTo(i(document)), window.removeEventListener("touchmove", this.handleTouchMoveProxy), window.removeEventListener("scroll", this.handleScrollProxy, !0)
                }, t.prototype.handleTouchStart = function(t) {
                    this.stopTouch(t, !0), this.isTouching = !0, this.trigger("touchstart", t)
                }, t.prototype.handleTouchMove = function(t) {
                    this.isTouching && this.trigger("touchmove", t)
                }, t.prototype.handleTouchCancel = function(t) {
                    this.isTouching && (this.trigger("touchcancel", t), this.stopTouch(t))
                }, t.prototype.handleTouchEnd = function(t) {
                    this.stopTouch(t)
                }, t.prototype.handleMouseDown = function(t) {
                    this.shouldIgnoreMouse() || this.trigger("mousedown", t)
                }, t.prototype.handleMouseMove = function(t) {
                    this.shouldIgnoreMouse() || this.trigger("mousemove", t)
                }, t.prototype.handleMouseUp = function(t) {
                    this.shouldIgnoreMouse() || this.trigger("mouseup", t)
                }, t.prototype.handleClick = function(t) {
                    this.shouldIgnoreMouse() || this.trigger("click", t)
                }, t.prototype.handleSelectStart = function(t) {
                    this.trigger("selectstart", t)
                }, t.prototype.handleContextMenu = function(t) {
                    this.trigger("contextmenu", t)
                }, t.prototype.handleScroll = function(t) {
                    this.trigger("scroll", t)
                }, t.prototype.stopTouch = function(t, e) {
                    void 0 === e && (e = !1), this.isTouching && (this.isTouching = !1, this.trigger("touchend", t), e || this.startTouchMouseIgnore())
                }, t.prototype.startTouchMouseIgnore = function() {
                    var t = this,
                        e = r.touchMouseIgnoreWait;
                    e && (this.mouseIgnoreDepth++, setTimeout(function() {
                        t.mouseIgnoreDepth--
                    }, e))
                }, t.prototype.shouldIgnoreMouse = function() {
                    return this.isTouching || Boolean(this.mouseIgnoreDepth)
                }, t
            }();
        e.default = u, s.default.mixInto(u), o.default.mixInto(u)
    }, function(t, n, e) {
        Object.defineProperty(n, "__esModule", {
            value: !0
        });
        var i = e(16);
        n.viewHash = {}, i.views = n.viewHash, n.defineView = function(t, e) {
            n.viewHash[t] = e
        }, n.getViewConfig = function(t) {
            return n.viewHash[t]
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            s = n(4),
            r = function(o) {
                function t(t, e) {
                    var n = o.call(this, e) || this;
                    return n.component = t, n
                }
                return i.__extends(t, o), t.prototype.handleInteractionStart = function(t) {
                    var e, n, i, r = this.subjectEl;
                    this.component.hitsNeeded(), this.computeScrollBounds(), t ? (i = n = {
                        left: s.getEvX(t),
                        top: s.getEvY(t)
                    }, r && (e = s.getOuterRect(r), i = s.constrainPoint(i, e)), this.origHit = this.queryHit(i.left, i.top), r && this.options.subjectCenter && (this.origHit && (e = s.intersectRects(this.origHit, e) || e), i = s.getRectCenter(e)), this.coordAdjust = s.diffPoints(i, n)) : (this.origHit = null, this.coordAdjust = null), o.prototype.handleInteractionStart.call(this, t)
                }, t.prototype.handleDragStart = function(t) {
                    var e;
                    o.prototype.handleDragStart.call(this, t), (e = this.queryHit(s.getEvX(t), s.getEvY(t))) && this.handleHitOver(e)
                }, t.prototype.handleDrag = function(t, e, n) {
                    var i;
                    o.prototype.handleDrag.call(this, t, e, n), a(i = this.queryHit(s.getEvX(n), s.getEvY(n)), this.hit) || (this.hit && this.handleHitOut(), i && this.handleHitOver(i))
                }, t.prototype.handleDragEnd = function(t) {
                    this.handleHitDone(), o.prototype.handleDragEnd.call(this, t)
                }, t.prototype.handleHitOver = function(t) {
                    var e = a(t, this.origHit);
                    this.hit = t, this.trigger("hitOver", this.hit, e, this.origHit)
                }, t.prototype.handleHitOut = function() {
                    this.hit && (this.trigger("hitOut", this.hit), this.handleHitDone(), this.hit = null)
                }, t.prototype.handleHitDone = function() {
                    this.hit && this.trigger("hitDone", this.hit)
                }, t.prototype.handleInteractionEnd = function(t, e) {
                    o.prototype.handleInteractionEnd.call(this, t, e), this.origHit = null, this.hit = null, this.component.hitsNotNeeded()
                }, t.prototype.handleScrollEnd = function() {
                    o.prototype.handleScrollEnd.call(this), this.isDragging && (this.component.releaseHits(), this.component.prepareHits())
                }, t.prototype.queryHit = function(t, e) {
                    return this.coordAdjust && (t += this.coordAdjust.left, e += this.coordAdjust.top), this.component.queryHit(t, e)
                }, t
            }(n(54).default);

        function a(t, e) {
            return !t && !e || !(!t || !e) && (t.component === e.component && o(t, e) && o(e, t))
        }

        function o(t, e) {
            for (var n in t)
                if (!/^(component|left|right|top|bottom)$/.test(n) && t[n] !== e[n]) return !1;
            return !0
        }
        e.default = r
    }, , , , , , , , function(t, o, e) {
        Object.defineProperty(o, "__esModule", {
            value: !0
        });
        var s = e(3),
            n = e(0),
            i = e(16),
            r = e(32),
            a = e(4);
        o.localeOptionHash = {}, i.locales = o.localeOptionHash;
        var l = {
                buttonText: function(t) {
                    return {
                        prev: a.stripHtmlEntities(t.prevText),
                        next: a.stripHtmlEntities(t.nextText),
                        today: a.stripHtmlEntities(t.currentText)
                    }
                },
                monthYearFormat: function(t) {
                    return t.showMonthAfterYear ? "YYYY[" + t.yearSuffix + "] MMMM" : "MMMM YYYY[" + t.yearSuffix + "]"
                }
            },
            u = {
                dayOfMonthFormat: function(t, e) {
                    var n = t.longDateFormat("l");
                    return n = n.replace(/^Y+[^\w\s]*|[^\w\s]*Y+$/g, ""), e.isRTL ? n += " ddd" : n = "ddd " + n, n
                },
                mediumTimeFormat: function(t) {
                    return t.longDateFormat("LT").replace(/\s*a$/i, "a")
                },
                smallTimeFormat: function(t) {
                    return t.longDateFormat("LT").replace(":mm", "(:mm)").replace(/(\Wmm)$/, "($1)").replace(/\s*a$/i, "a")
                },
                extraSmallTimeFormat: function(t) {
                    return t.longDateFormat("LT").replace(":mm", "(:mm)").replace(/(\Wmm)$/, "($1)").replace(/\s*a$/i, "t")
                },
                hourFormat: function(t) {
                    return t.longDateFormat("LT").replace(":mm", "").replace(/(\Wmm)$/, "").replace(/\s*a$/i, "a")
                },
                noMeridiemTimeFormat: function(t) {
                    return t.longDateFormat("LT").replace(/\s*a$/i, "")
                }
            },
            d = {
                smallDayDateFormat: function(t) {
                    return t.isRTL ? "D dd" : "dd D"
                },
                weekFormat: function(t) {
                    return t.isRTL ? "w[ " + t.weekNumberTitle + "]" : "[" + t.weekNumberTitle + " ]w"
                },
                smallWeekFormat: function(t) {
                    return t.isRTL ? "w[" + t.weekNumberTitle + "]" : "[" + t.weekNumberTitle + "]w"
                }
            };

        function c(t, e) {
            var n, i;
            n = o.localeOptionHash[t] || (o.localeOptionHash[t] = {}), e && (n = o.localeOptionHash[t] = r.mergeOptions([n, e])), i = p(t), s.each(u, function(t, e) {
                null == n[t] && (n[t] = e(i, n))
            }), r.globalDefaults.locale = t
        }

        function p(t) {
            return n.localeData(t) || n.localeData("en")
        }
        o.populateInstanceComputableOptions = function(n) {
            s.each(d, function(t, e) {
                null == n[t] && (n[t] = e(n))
            })
        }, o.datepickerLocale = function(t, e, n) {
            var i = o.localeOptionHash[t] || (o.localeOptionHash[t] = {});
            i.isRTL = n.isRTL, i.weekNumberTitle = n.weekHeader, s.each(l, function(t, e) {
                i[t] = e(n)
            });
            var r = s.datepicker;
            r && (r.regional[e] = r.regional[t] = n, r.regional.en = r.regional[""], r.setDefaults(n))
        }, o.locale = c, o.getMomentLocaleData = p, c("en", r.englishDefaults)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(4);
        e.globalDefaults = {
            titleRangeSeparator: " – ",
            monthYearFormat: "MMMM YYYY",
            defaultTimedEventDuration: "02:00:00",
            defaultAllDayEventDuration: {
                days: 1
            },
            forceEventDuration: !1,
            nextDayThreshold: "09:00:00",
            columnHeader: !0,
            defaultView: "month",
            aspectRatio: 1.35,
            header: {
                left: "title",
                center: "",
                right: "today prev,next"
            },
            weekends: !0,
            weekNumbers: !1,
            weekNumberTitle: "W",
            weekNumberCalculation: "local",
            scrollTime: "06:00:00",
            minTime: "00:00:00",
            maxTime: "24:00:00",
            showNonCurrentDates: !0,
            lazyFetching: !0,
            startParam: "start",
            endParam: "end",
            timezoneParam: "timezone",
            timezone: !1,
            locale: null,
            isRTL: !1,
            buttonText: {
                prev: "prev",
                next: "next",
                prevYear: "prev year",
                nextYear: "next year",
                year: "year",
                today: "today",
                month: "month",
                week: "week",
                day: "day"
            },
            allDayText: "all-day",
            agendaEventMinHeight: 0,
            theme: !1,
            dragOpacity: .75,
            dragRevertDuration: 500,
            dragScroll: !0,
            unselectAuto: !0,
            dropAccept: "*",
            eventOrder: "title",
            eventLimit: !1,
            eventLimitText: "more",
            eventLimitClick: "popover",
            dayPopoverFormat: "LL",
            handleWindowResize: !0,
            windowResizeDelay: 100,
            longPressDelay: 1e3
        }, e.englishDefaults = {
            dayPopoverFormat: "dddd, MMMM D"
        }, e.rtlDefaults = {
            header: {
                left: "next,prev today",
                center: "",
                right: "title"
            },
            buttonIcons: {
                prev: "right-single-arrow",
                next: "left-single-arrow",
                prevYear: "right-double-arrow",
                nextYear: "left-double-arrow"
            },
            themeButtonIcons: {
                prev: "circle-triangle-e",
                next: "circle-triangle-w",
                nextYear: "seek-prev",
                prevYear: "seek-next"
            }
        };
        var r = ["header", "footer", "buttonText", "buttonIcons", "themeButtonIcons"];
        e.mergeOptions = function(t) {
            return i.mergeProps(t, r)
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(4),
            o = function() {
                function t() {}
                return t.extend = function(t) {
                    var e = function(t) {
                        function e() {
                            return null !== t && t.apply(this, arguments) || this
                        }
                        return i.__extends(e, t), e
                    }(this);
                    return r.copyOwnProps(t, e.prototype), e
                }, t.mixin = function(t) {
                    r.copyOwnProps(t, this.prototype)
                }, t
            }();
        e.default = o
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(3),
            r = n(208),
            o = function() {
                function e(t) {
                    this.source = t, this.className = [], this.miscProps = {}
                }
                return e.parse = function(t, e) {
                    var n = new this(e);
                    return !!n.applyProps(t) && n
                }, e.normalizeId = function(t) {
                    return String(t)
                }, e.generateId = function() {
                    return "_fc" + e.uuid++
                }, e.prototype.clone = function() {
                    var t = new this.constructor(this.source);
                    return t.id = this.id, t.rawId = this.rawId, t.uid = this.uid, e.copyVerbatimStandardProps(this, t), t.className = this.className.slice(), t.miscProps = i.extend({}, this.miscProps), t
                }, e.prototype.hasInverseRendering = function() {
                    return "inverse-background" === this.getRendering()
                }, e.prototype.hasBgRendering = function() {
                    var t = this.getRendering();
                    return "inverse-background" === t || "background" === t
                }, e.prototype.getRendering = function() {
                    return null != this.rendering ? this.rendering : this.source.rendering
                }, e.prototype.getConstraint = function() {
                    return null != this.constraint ? this.constraint : null != this.source.constraint ? this.source.constraint : this.source.calendar.opt("eventConstraint")
                }, e.prototype.getOverlap = function() {
                    return null != this.overlap ? this.overlap : null != this.source.overlap ? this.source.overlap : this.source.calendar.opt("eventOverlap")
                }, e.prototype.isStartExplicitlyEditable = function() {
                    return null != this.startEditable ? this.startEditable : this.source.startEditable
                }, e.prototype.isDurationExplicitlyEditable = function() {
                    return null != this.durationEditable ? this.durationEditable : this.source.durationEditable
                }, e.prototype.isExplicitlyEditable = function() {
                    return null != this.editable ? this.editable : this.source.editable
                }, e.prototype.toLegacy = function() {
                    var t = i.extend({}, this.miscProps);
                    return t._id = this.uid, t.source = this.source, t.className = this.className.slice(), t.allDay = this.isAllDay(), null != this.rawId && (t.id = this.rawId), e.copyVerbatimStandardProps(this, t), t
                }, e.prototype.applyManualStandardProps = function(t) {
                    return null != t.id ? this.id = e.normalizeId(this.rawId = t.id) : this.id = e.generateId(), null != t._id ? this.uid = String(t._id) : this.uid = e.generateId(), i.isArray(t.className) && (this.className = t.className), "string" == typeof t.className && (this.className = t.className.split(/\s+/)), !0
                }, e.prototype.applyMiscProps = function(t) {
                    i.extend(this.miscProps, t)
                }, e.uuid = 0, e.defineStandardProps = r.default.defineStandardProps, e.copyVerbatimStandardProps = r.default.copyVerbatimStandardProps, e
            }();
        e.default = o, r.default.mixInto(o), o.defineStandardProps({
            _id: !1,
            id: !1,
            className: !1,
            source: !1,
            title: !0,
            url: !0,
            rendering: !0,
            constraint: !0,
            overlap: !0,
            editable: !0,
            startEditable: !0,
            durationEditable: !0,
            color: !0,
            backgroundColor: !0,
            borderColor: !0,
            textColor: !0
        })
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(211),
            r = n(36),
            o = n(12);
        e.eventDefsToEventInstances = function(t, e) {
            var n, i = [];
            for (n = 0; n < t.length; n++) i.push.apply(i, t[n].buildInstances(e));
            return i
        }, e.eventInstanceToEventRange = function(t) {
            return new i.default(t.dateProfile.unzonedRange, t.def, t)
        }, e.eventRangeToEventFootprint = function(t) {
            return new r.default(new o.default(t.unzonedRange, t.eventDef.isAllDay()), t.eventDef, t.eventInstance)
        }, e.eventInstanceToUnzonedRange = function(t) {
            return t.dateProfile.unzonedRange
        }, e.eventFootprintToComponentFootprint = function(t) {
            return t.componentFootprint
        }
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function() {
            function t(t, e, n) {
                this.componentFootprint = t, this.eventDef = e, n && (this.eventInstance = n)
            }
            return t.prototype.getEventLegacy = function() {
                return (this.eventInstance || this.eventDef).toLegacy()
            }, t
        }();
        e.default = n
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var g = n(4),
            v = n(17),
            y = n(34),
            m = n(50),
            i = n(13),
            r = function() {
                function f() {}
                return f.createFromRawProps = function(t, e, n) {
                    var i, r, o, s, a = t.def,
                        l = {},
                        u = {},
                        d = {},
                        c = {},
                        p = null,
                        h = null;
                    for (i in e) v.default.isStandardProp(i) ? l[i] = e[i] : a.isStandardProp(i) ? u[i] = e[i] : a.miscProps[i] !== e[i] && (d[i] = e[i]);
                    return (r = v.default.parse(l, a.source)) && (o = m.default.createFromDiff(t.dateProfile, r, n)), u.id !== a.id && (p = u.id), g.isArraysEqual(u.className, a.className) || (h = u.className), y.default.copyVerbatimStandardProps(u, c), (s = new f).eventDefId = p, s.className = h, s.verbatimStandardProps = c, s.miscProps = d, o && (s.dateMutation = o), s
                }, f.prototype.mutateSingle = function(t) {
                    var e;
                    return this.dateMutation && (e = t.dateProfile, t.dateProfile = this.dateMutation.buildNewDateProfile(e, t.source.calendar)), null != this.eventDefId && (t.id = y.default.normalizeId(t.rawId = this.eventDefId)), this.className && (t.className = this.className), this.verbatimStandardProps && i.default.copyVerbatimStandardProps(this.verbatimStandardProps, t), this.miscProps && t.applyMiscProps(this.miscProps), e ? function() {
                        t.dateProfile = e
                    } : function() {}
                }, f.prototype.setDateMutation = function(t) {
                    t && !t.isEmpty() ? this.dateMutation = t : this.dateMutation = null
                }, f.prototype.isEmpty = function() {
                    return !this.dateMutation
                }, f
            }();
        e.default = r
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        }), e.default = {
            sourceClasses: [],
            registerClass: function(t) {
                this.sourceClasses.unshift(t)
            },
            parse: function(t, e) {
                var n, i, r = this.sourceClasses;
                for (n = 0; n < r.length; n++)
                    if (i = r[n].parse(t, e)) return i
            }
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(3),
            o = n(4),
            s = function(n) {
                function t(t) {
                    var e = n.call(this) || this;
                    return t = t || {}, e.overflowX = t.overflowX || t.overflow || "auto", e.overflowY = t.overflowY || t.overflow || "auto", e
                }
                return i.__extends(t, n), t.prototype.render = function() {
                    this.el = this.renderEl(), this.applyOverflow()
                }, t.prototype.renderEl = function() {
                    return this.scrollEl = r('<div class="fc-scroller"></div>')
                }, t.prototype.clear = function() {
                    this.setHeight("auto"), this.applyOverflow()
                }, t.prototype.destroy = function() {
                    this.el.remove()
                }, t.prototype.applyOverflow = function() {
                    this.scrollEl.css({
                        "overflow-x": this.overflowX,
                        "overflow-y": this.overflowY
                    })
                }, t.prototype.lockOverflow = function(t) {
                    var e = this.overflowX,
                        n = this.overflowY;
                    t = t || this.getScrollbarWidths(), "auto" === e && (e = t.top || t.bottom || this.scrollEl[0].scrollWidth - 1 > this.scrollEl[0].clientWidth ? "scroll" : "hidden"), "auto" === n && (n = t.left || t.right || this.scrollEl[0].scrollHeight - 1 > this.scrollEl[0].clientHeight ? "scroll" : "hidden"), this.scrollEl.css({
                        "overflow-x": e,
                        "overflow-y": n
                    })
                }, t.prototype.setHeight = function(t) {
                    this.scrollEl.height(t)
                }, t.prototype.getScrollTop = function() {
                    return this.scrollEl.scrollTop()
                }, t.prototype.setScrollTop = function(t) {
                    this.scrollEl.scrollTop(t)
                }, t.prototype.getClientWidth = function() {
                    return this.scrollEl[0].clientWidth
                }, t.prototype.getClientHeight = function() {
                    return this.scrollEl[0].clientHeight
                }, t.prototype.getScrollbarWidths = function() {
                    return o.getScrollbarWidths(this.scrollEl)
                }, t
            }(n(33).default);
        e.default = s
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            o = n(3),
            s = n(4),
            i = n(219),
            a = n(21),
            l = function(i) {
                function t(t, e) {
                    var n = i.call(this, t, e) || this;
                    return n.segSelector = ".fc-event-container > *", n.dateSelectingClass && (n.dateClicking = new n.dateClickingClass(n)), n.dateSelectingClass && (n.dateSelecting = new n.dateSelectingClass(n)), n.eventPointingClass && (n.eventPointing = new n.eventPointingClass(n)), n.eventDraggingClass && n.eventPointing && (n.eventDragging = new n.eventDraggingClass(n, n.eventPointing)), n.eventResizingClass && n.eventPointing && (n.eventResizing = new n.eventResizingClass(n, n.eventPointing)), n.externalDroppingClass && (n.externalDropping = new n.externalDroppingClass(n)), n
                }
                return r.__extends(t, i), t.prototype.setElement = function(t) {
                    i.prototype.setElement.call(this, t), this.dateClicking && this.dateClicking.bindToEl(t), this.dateSelecting && this.dateSelecting.bindToEl(t), this.bindAllSegHandlersToEl(t)
                }, t.prototype.removeElement = function() {
                    this.endInteractions(), i.prototype.removeElement.call(this)
                }, t.prototype.executeEventUnrender = function() {
                    this.endInteractions(), i.prototype.executeEventUnrender.call(this)
                }, t.prototype.bindGlobalHandlers = function() {
                    i.prototype.bindGlobalHandlers.call(this), this.externalDropping && this.externalDropping.bindToDocument()
                }, t.prototype.unbindGlobalHandlers = function() {
                    i.prototype.unbindGlobalHandlers.call(this), this.externalDropping && this.externalDropping.unbindFromDocument()
                }, t.prototype.bindDateHandlerToEl = function(t, e, n) {
                    var i = this;
                    this.el.on(e, function(t) {
                        if (!o(t.target).is(i.segSelector + ":not(.fc-helper)," + i.segSelector + ":not(.fc-helper) *,.fc-more,a[data-goto]")) return n.call(i, t)
                    })
                }, t.prototype.bindAllSegHandlersToEl = function(e) {
                    [this.eventPointing, this.eventDragging, this.eventResizing].forEach(function(t) {
                        t && t.bindToEl(e)
                    })
                }, t.prototype.bindSegHandlerToEl = function(t, e, i) {
                    var r = this;
                    t.on(e, this.segSelector, function(t) {
                        var e = o(t.currentTarget);
                        if (!e.is(".fc-helper")) {
                            var n = e.data("fc-seg");
                            if (n && !r.shouldIgnoreEventPointing()) return i.call(r, n, t)
                        }
                    })
                }, t.prototype.shouldIgnoreMouse = function() {
                    return a.default.get().shouldIgnoreMouse()
                }, t.prototype.shouldIgnoreTouch = function() {
                    var t = this._getView();
                    return t.isSelected || t.selectedEvent
                }, t.prototype.shouldIgnoreEventPointing = function() {
                    return this.eventDragging && this.eventDragging.isDragging || this.eventResizing && this.eventResizing.isResizing
                }, t.prototype.canStartSelection = function(t, e) {
                    return s.getEvIsTouch(e) && !this.canStartResize(t, e) && (this.isEventDefDraggable(t.footprint.eventDef) || this.isEventDefResizable(t.footprint.eventDef))
                }, t.prototype.canStartDrag = function(t, e) {
                    return !this.canStartResize(t, e) && this.isEventDefDraggable(t.footprint.eventDef)
                }, t.prototype.canStartResize = function(t, e) {
                    var n = this._getView(),
                        i = t.footprint.eventDef;
                    return (!s.getEvIsTouch(e) || n.isEventDefSelected(i)) && this.isEventDefResizable(i) && o(e.target).is(".fc-resizer")
                }, t.prototype.endInteractions = function() {
                    [this.dateClicking, this.dateSelecting, this.eventPointing, this.eventDragging, this.eventResizing].forEach(function(t) {
                        t && t.end()
                    })
                }, t.prototype.isEventDefDraggable = function(t) {
                    return this.isEventDefStartEditable(t)
                }, t.prototype.isEventDefStartEditable = function(t) {
                    var e = t.isStartExplicitlyEditable();
                    return null == e && null == (e = this.opt("eventStartEditable")) && (e = this.isEventDefGenerallyEditable(t)), e
                }, t.prototype.isEventDefGenerallyEditable = function(t) {
                    var e = t.isExplicitlyEditable();
                    return null == e && (e = this.opt("editable")), e
                }, t.prototype.isEventDefResizableFromStart = function(t) {
                    return this.opt("eventResizableFromStart") && this.isEventDefResizable(t)
                }, t.prototype.isEventDefResizableFromEnd = function(t) {
                    return this.isEventDefResizable(t)
                }, t.prototype.isEventDefResizable = function(t) {
                    var e = t.isDurationExplicitlyEditable();
                    return null == e && null == (e = this.opt("eventDurationEditable")) && (e = this.isEventDefGenerallyEditable(t)), e
                }, t.prototype.diffDates = function(t, e) {
                    return this.largeUnit ? s.diffByUnit(t, e, this.largeUnit) : s.diffDayTime(t, e)
                }, t.prototype.isEventInstanceGroupAllowed = function(t) {
                    var e, n = this._getView(),
                        i = this.dateProfile,
                        r = this.eventRangesToEventFootprints(t.getAllEventRanges());
                    for (e = 0; e < r.length; e++)
                        if (!i.validUnzonedRange.containsRange(r[e].componentFootprint.unzonedRange)) return !1;
                    return n.calendar.constraints.isEventInstanceGroupAllowed(t)
                }, t.prototype.isExternalInstanceGroupAllowed = function(t) {
                    var e, n = this._getView(),
                        i = this.dateProfile,
                        r = this.eventRangesToEventFootprints(t.getAllEventRanges());
                    for (e = 0; e < r.length; e++)
                        if (!i.validUnzonedRange.containsRange(r[e].componentFootprint.unzonedRange)) return !1;
                    for (e = 0; e < r.length; e++)
                        if (!n.calendar.constraints.isSelectionFootprintAllowed(r[e].componentFootprint)) return !1;
                    return !0
                }, t
            }(i.default);
        e.default = l
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            o = n(3),
            s = n(0),
            a = n(4),
            l = n(218),
            i = n(221),
            u = n(40),
            d = n(21),
            c = n(5),
            p = function(i) {
                function t(t, e) {
                    var n = i.call(this, null, e.options) || this;
                    return n.batchRenderDepth = 0, n.isSelected = !1, n.calendar = t, n.viewSpec = e, n.type = e.type, n.name = n.type, n.initRenderQueue(), n.initHiddenDays(), n.dateProfileGenerator = new n.dateProfileGeneratorClass(n), n.bindBaseRenderHandlers(), n.eventOrderSpecs = a.parseFieldSpecs(n.opt("eventOrder")), n.initialize && n.initialize(), n
                }
                return r.__extends(t, i), t.prototype._getView = function() {
                    return this
                }, t.prototype.opt = function(t) {
                    return this.options[t]
                }, t.prototype.initRenderQueue = function() {
                    this.renderQueue = new l.default({
                        event: this.opt("eventRenderWait")
                    }), this.renderQueue.on("start", this.onRenderQueueStart.bind(this)), this.renderQueue.on("stop", this.onRenderQueueStop.bind(this)), this.on("before:change", this.startBatchRender), this.on("change", this.stopBatchRender)
                }, t.prototype.onRenderQueueStart = function() {
                    this.calendar.freezeContentHeight(), this.addScroll(this.queryScroll())
                }, t.prototype.onRenderQueueStop = function() {
                    this.calendar.updateViewSize() && this.popScroll(), this.calendar.thawContentHeight()
                }, t.prototype.startBatchRender = function() {
                    this.batchRenderDepth++ || this.renderQueue.pause()
                }, t.prototype.stopBatchRender = function() {
                    --this.batchRenderDepth || this.renderQueue.resume()
                }, t.prototype.requestRender = function(t, e, n) {
                    this.renderQueue.queue(t, e, n)
                }, t.prototype.whenSizeUpdated = function(t) {
                    this.renderQueue.isRunning ? this.renderQueue.one("stop", t.bind(this)) : t.call(this)
                }, t.prototype.computeTitle = function(t) {
                    var e;
                    return e = /^(year|month)$/.test(t.currentRangeUnit) ? t.currentUnzonedRange : t.activeUnzonedRange, this.formatRange({
                        start: this.calendar.msToMoment(e.startMs, t.isRangeAllDay),
                        end: this.calendar.msToMoment(e.endMs, t.isRangeAllDay)
                    }, t.isRangeAllDay, this.opt("titleFormat") || this.computeTitleFormat(t), this.opt("titleRangeSeparator"))
                }, t.prototype.computeTitleFormat = function(t) {
                    var e = t.currentRangeUnit;
                    return "year" === e ? "YYYY" : "month" === e ? this.opt("monthYearFormat") : 1 < t.currentUnzonedRange.as("days") ? "ll" : "LL"
                }, t.prototype.setDate = function(t) {
                    var e = this.get("dateProfile"),
                        n = this.dateProfileGenerator.build(t, void 0, !0);
                    e && e.activeUnzonedRange.equals(n.activeUnzonedRange) || this.set("dateProfile", n)
                }, t.prototype.unsetDate = function() {
                    this.unset("dateProfile")
                }, t.prototype.fetchInitialEvents = function(t) {
                    var e = this.calendar,
                        n = t.isRangeAllDay && !this.usesMinMaxTime;
                    return e.requestEvents(e.msToMoment(t.activeUnzonedRange.startMs, n), e.msToMoment(t.activeUnzonedRange.endMs, n))
                }, t.prototype.bindEventChanges = function() {
                    this.listenTo(this.calendar, "eventsReset", this.resetEvents)
                }, t.prototype.unbindEventChanges = function() {
                    this.stopListeningTo(this.calendar, "eventsReset")
                }, t.prototype.setEvents = function(t) {
                    this.set("currentEvents", t), this.set("hasEvents", !0)
                }, t.prototype.unsetEvents = function() {
                    this.unset("currentEvents"), this.unset("hasEvents")
                }, t.prototype.resetEvents = function(t) {
                    this.startBatchRender(), this.unsetEvents(), this.setEvents(t), this.stopBatchRender()
                }, t.prototype.requestDateRender = function(t) {
                    var e = this;
                    this.requestRender(function() {
                        e.executeDateRender(t)
                    }, "date", "init")
                }, t.prototype.requestDateUnrender = function() {
                    var t = this;
                    this.requestRender(function() {
                        t.executeDateUnrender()
                    }, "date", "destroy")
                }, t.prototype.executeDateRender = function(t) {
                    i.prototype.executeDateRender.call(this, t), this.render && this.render(), this.trigger("datesRendered"), this.addScroll({
                        isDateInit: !0
                    }), this.startNowIndicator()
                }, t.prototype.executeDateUnrender = function() {
                    this.unselect(), this.stopNowIndicator(), this.trigger("before:datesUnrendered"), this.destroy && this.destroy(), i.prototype.executeDateUnrender.call(this)
                }, t.prototype.bindBaseRenderHandlers = function() {
                    var t = this;
                    this.on("datesRendered", function() {
                        t.whenSizeUpdated(t.triggerViewRender)
                    }), this.on("before:datesUnrendered", function() {
                        t.triggerViewDestroy()
                    })
                }, t.prototype.triggerViewRender = function() {
                    this.publiclyTrigger("viewRender", {
                        context: this,
                        args: [this, this.el]
                    })
                }, t.prototype.triggerViewDestroy = function() {
                    this.publiclyTrigger("viewDestroy", {
                        context: this,
                        args: [this, this.el]
                    })
                }, t.prototype.requestEventsRender = function(t) {
                    var e = this;
                    this.requestRender(function() {
                        e.executeEventRender(t), e.whenSizeUpdated(e.triggerAfterEventsRendered)
                    }, "event", "init")
                }, t.prototype.requestEventsUnrender = function() {
                    var t = this;
                    this.requestRender(function() {
                        t.triggerBeforeEventsDestroyed(), t.executeEventUnrender()
                    }, "event", "destroy")
                }, t.prototype.requestBusinessHoursRender = function(t) {
                    var e = this;
                    this.requestRender(function() {
                        e.renderBusinessHours(t)
                    }, "businessHours", "init")
                }, t.prototype.requestBusinessHoursUnrender = function() {
                    var t = this;
                    this.requestRender(function() {
                        t.unrenderBusinessHours()
                    }, "businessHours", "destroy")
                }, t.prototype.bindGlobalHandlers = function() {
                    i.prototype.bindGlobalHandlers.call(this), this.listenTo(d.default.get(), {
                        touchstart: this.processUnselect,
                        mousedown: this.handleDocumentMousedown
                    })
                }, t.prototype.unbindGlobalHandlers = function() {
                    i.prototype.unbindGlobalHandlers.call(this), this.stopListeningTo(d.default.get())
                }, t.prototype.startNowIndicator = function() {
                    var t, e, n, i = this;
                    this.opt("nowIndicator") && (t = this.getNowIndicatorUnit()) && (e = a.proxy(this, "updateNowIndicator"), this.initialNowDate = this.calendar.getNow(), this.initialNowQueriedMs = (new Date).valueOf(), n = this.initialNowDate.clone().startOf(t).add(1, t).valueOf() - this.initialNowDate.valueOf(), this.nowIndicatorTimeoutID = setTimeout(function() {
                        i.nowIndicatorTimeoutID = null, e(), n = +s.duration(1, t), n = Math.max(100, n), i.nowIndicatorIntervalID = setInterval(e, n)
                    }, n))
                }, t.prototype.updateNowIndicator = function() {
                    this.isDatesRendered && this.initialNowDate && (this.unrenderNowIndicator(), this.renderNowIndicator(this.initialNowDate.clone().add((new Date).valueOf() - this.initialNowQueriedMs)), this.isNowIndicatorRendered = !0)
                }, t.prototype.stopNowIndicator = function() {
                    this.isNowIndicatorRendered && (this.nowIndicatorTimeoutID && (clearTimeout(this.nowIndicatorTimeoutID), this.nowIndicatorTimeoutID = null), this.nowIndicatorIntervalID && (clearInterval(this.nowIndicatorIntervalID), this.nowIndicatorIntervalID = null), this.unrenderNowIndicator(), this.isNowIndicatorRendered = !1)
                }, t.prototype.updateSize = function(t, e, n) {
                    this.setHeight ? this.setHeight(t, e) : i.prototype.updateSize.call(this, t, e, n), this.updateNowIndicator()
                }, t.prototype.addScroll = function(t) {
                    var e = this.queuedScroll || (this.queuedScroll = {});
                    o.extend(e, t)
                }, t.prototype.popScroll = function() {
                    this.applyQueuedScroll(), this.queuedScroll = null
                }, t.prototype.applyQueuedScroll = function() {
                    this.queuedScroll && this.applyScroll(this.queuedScroll)
                }, t.prototype.queryScroll = function() {
                    var t = {};
                    return this.isDatesRendered && o.extend(t, this.queryDateScroll()), t
                }, t.prototype.applyScroll = function(t) {
                    t.isDateInit && this.isDatesRendered && o.extend(t, this.computeInitialDateScroll()), this.isDatesRendered && this.applyDateScroll(t)
                }, t.prototype.computeInitialDateScroll = function() {
                    return {}
                }, t.prototype.queryDateScroll = function() {
                    return {}
                }, t.prototype.applyDateScroll = function(t) {}, t.prototype.reportEventDrop = function(t, e, n, i) {
                    var r = this.calendar.eventManager.mutateEventsWithId(t.def.id, e),
                        o = e.dateMutation;
                    o && (t.dateProfile = o.buildNewDateProfile(t.dateProfile, this.calendar)), this.triggerEventDrop(t, o && o.dateDelta || s.duration(), r, n, i)
                }, t.prototype.triggerEventDrop = function(t, e, n, i, r) {
                    this.publiclyTrigger("eventDrop", {
                        context: i[0],
                        args: [t.toLegacy(), e, n, r, {}, this]
                    })
                }, t.prototype.reportExternalDrop = function(t, e, n, i, r, o) {
                    e && this.calendar.eventManager.addEventDef(t, n), this.triggerExternalDrop(t, e, i, r, o)
                }, t.prototype.triggerExternalDrop = function(t, e, n, i, r) {
                    this.publiclyTrigger("drop", {
                        context: n[0],
                        args: [t.dateProfile.start.clone(), i, r, this]
                    }), e && this.publiclyTrigger("eventReceive", {
                        context: this,
                        args: [t.buildInstance().toLegacy(), this]
                    })
                }, t.prototype.reportEventResize = function(t, e, n, i) {
                    var r = this.calendar.eventManager.mutateEventsWithId(t.def.id, e);
                    t.dateProfile = e.dateMutation.buildNewDateProfile(t.dateProfile, this.calendar), this.triggerEventResize(t, e.dateMutation.endDelta, r, n, i)
                }, t.prototype.triggerEventResize = function(t, e, n, i, r) {
                    this.publiclyTrigger("eventResize", {
                        context: i[0],
                        args: [t.toLegacy(), e, n, r, {}, this]
                    })
                }, t.prototype.select = function(t, e) {
                    this.unselect(e), this.renderSelectionFootprint(t), this.reportSelection(t, e)
                }, t.prototype.renderSelectionFootprint = function(t) {
                    this.renderSelection ? this.renderSelection(t.toLegacy(this.calendar)) : i.prototype.renderSelectionFootprint.call(this, t)
                }, t.prototype.reportSelection = function(t, e) {
                    this.isSelected = !0, this.triggerSelect(t, e)
                }, t.prototype.triggerSelect = function(t, e) {
                    var n = this.calendar.footprintToDateProfile(t);
                    this.publiclyTrigger("select", {
                        context: this,
                        args: [n.start, n.end, e, this]
                    })
                }, t.prototype.unselect = function(t) {
                    this.isSelected && (this.isSelected = !1, this.destroySelection && this.destroySelection(), this.unrenderSelection(), this.publiclyTrigger("unselect", {
                        context: this,
                        args: [t, this]
                    }))
                }, t.prototype.selectEventInstance = function(e) {
                    this.selectedEventInstance && this.selectedEventInstance === e || (this.unselectEventInstance(), this.getEventSegs().forEach(function(t) {
                        t.footprint.eventInstance === e && t.el && t.el.addClass("fc-selected")
                    }), this.selectedEventInstance = e)
                }, t.prototype.unselectEventInstance = function() {
                    this.selectedEventInstance && (this.getEventSegs().forEach(function(t) {
                        t.el && t.el.removeClass("fc-selected")
                    }), this.selectedEventInstance = null)
                }, t.prototype.isEventDefSelected = function(t) {
                    return this.selectedEventInstance && this.selectedEventInstance.def.id === t.id
                }, t.prototype.handleDocumentMousedown = function(t) {
                    a.isPrimaryMouseButton(t) && this.processUnselect(t)
                }, t.prototype.processUnselect = function(t) {
                    this.processRangeUnselect(t), this.processEventUnselect(t)
                }, t.prototype.processRangeUnselect = function(t) {
                    var e;
                    this.isSelected && this.opt("unselectAuto") && ((e = this.opt("unselectCancel")) && o(t.target).closest(e).length || this.unselect(t))
                }, t.prototype.processEventUnselect = function(t) {
                    this.selectedEventInstance && (o(t.target).closest(".fc-selected").length || this.unselectEventInstance())
                }, t.prototype.triggerBaseRendered = function() {
                    this.publiclyTrigger("viewRender", {
                        context: this,
                        args: [this, this.el]
                    })
                }, t.prototype.triggerBaseUnrendered = function() {
                    this.publiclyTrigger("viewDestroy", {
                        context: this,
                        args: [this, this.el]
                    })
                }, t.prototype.triggerDayClick = function(t, e, n) {
                    var i = this.calendar.footprintToDateProfile(t);
                    this.publiclyTrigger("dayClick", {
                        context: e,
                        args: [i.start, n, this]
                    })
                }, t.prototype.isDateInOtherMonth = function(t, e) {
                    return !1
                }, t.prototype.getUnzonedRangeOption = function(t) {
                    var e = this.opt(t);
                    if ("function" == typeof e && (e = e.apply(null, Array.prototype.slice.call(arguments, 1))), e) return this.calendar.parseUnzonedRange(e)
                }, t.prototype.initHiddenDays = function() {
                    var t, e = this.opt("hiddenDays") || [],
                        n = [],
                        i = 0;
                    for (!1 === this.opt("weekends") && e.push(0, 6), t = 0; t < 7; t++)(n[t] = -1 !== o.inArray(t, e)) || i++;
                    if (!i) throw new Error("invalid hiddenDays");
                    this.isHiddenDayHash = n
                }, t.prototype.trimHiddenDays = function(t) {
                    var e = t.getStart(),
                        n = t.getEnd();
                    return e && (e = this.skipHiddenDays(e)), n && (n = this.skipHiddenDays(n, -1, !0)), null === e || null === n || e < n ? new c.default(e, n) : null
                }, t.prototype.isHiddenDay = function(t) {
                    return s.isMoment(t) && (t = t.day()), this.isHiddenDayHash[t]
                }, t.prototype.skipHiddenDays = function(t, e, n) {
                    void 0 === e && (e = 1), void 0 === n && (n = !1);
                    for (var i = t.clone(); this.isHiddenDayHash[(i.day() + (n ? e : 0) + 7) % 7];) i.add(e, "days");
                    return i
                }, t
            }(u.default);
        (e.default = p).prototype.usesMinMaxTime = !1, p.prototype.dateProfileGeneratorClass = i.default, p.watch("displayingDates", ["isInDom", "dateProfile"], function(t) {
            this.requestDateRender(t.dateProfile)
        }, function() {
            this.requestDateUnrender()
        }), p.watch("displayingBusinessHours", ["displayingDates", "businessHourGenerator"], function(t) {
            this.requestBusinessHoursRender(t.businessHourGenerator)
        }, function() {
            this.requestBusinessHoursUnrender()
        }), p.watch("initialEvents", ["dateProfile"], function(t) {
            return this.fetchInitialEvents(t.dateProfile)
        }), p.watch("bindingEvents", ["initialEvents"], function(t) {
            this.setEvents(t.initialEvents), this.bindEventChanges()
        }, function() {
            this.unbindEventChanges(), this.unsetEvents()
        }), p.watch("displayingEvents", ["displayingDates", "hasEvents"], function() {
            this.requestEventsRender(this.get("currentEvents"))
        }, function() {
            this.requestEventsUnrender()
        }), p.watch("title", ["dateProfile"], function(t) {
            return this.title = this.computeTitle(t.dateProfile)
        }), p.watch("legacyDateProps", ["dateProfile"], function(t) {
            var e = this.calendar,
                n = t.dateProfile;
            this.start = e.msToMoment(n.activeUnzonedRange.startMs, n.isRangeAllDay), this.end = e.msToMoment(n.activeUnzonedRange.endMs, n.isRangeAllDay), this.intervalStart = e.msToMoment(n.currentUnzonedRange.startMs, n.isRangeAllDay), this.intervalEnd = e.msToMoment(n.currentUnzonedRange.endMs, n.isRangeAllDay)
        })
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var l = n(3),
            u = n(4),
            i = function() {
                function t(t, e) {
                    this.view = t._getView(), this.component = t, this.fillRenderer = e
                }
                return t.prototype.opt = function(t) {
                    return this.view.opt(t)
                }, t.prototype.rangeUpdated = function() {
                    var t, e;
                    this.eventTimeFormat = this.opt("eventTimeFormat") || this.opt("timeFormat") || this.computeEventTimeFormat(), null == (t = this.opt("displayEventTime")) && (t = this.computeDisplayEventTime()), null == (e = this.opt("displayEventEnd")) && (e = this.computeDisplayEventEnd()), this.displayEventTime = t, this.displayEventEnd = e
                }, t.prototype.render = function(t) {
                    var e, n, i, r = this.component._getDateProfile(),
                        o = [],
                        s = [];
                    for (e in t) i = (n = t[e]).sliceRenderRanges(r.activeUnzonedRange), n.getEventDef().hasBgRendering() ? o.push.apply(o, i) : s.push.apply(s, i);
                    this.renderBgRanges(o), this.renderFgRanges(s)
                }, t.prototype.unrender = function() {
                    this.unrenderBgRanges(), this.unrenderFgRanges()
                }, t.prototype.renderFgRanges = function(t) {
                    var e = this.component.eventRangesToEventFootprints(t),
                        n = this.component.eventFootprintsToSegs(e);
                    n = this.renderFgSegEls(n), !1 !== this.renderFgSegs(n) && (this.fgSegs = n)
                }, t.prototype.unrenderFgRanges = function() {
                    this.unrenderFgSegs(this.fgSegs || []), this.fgSegs = null
                }, t.prototype.renderBgRanges = function(t) {
                    var e = this.component.eventRangesToEventFootprints(t),
                        n = this.component.eventFootprintsToSegs(e);
                    !1 !== this.renderBgSegs(n) && (this.bgSegs = n)
                }, t.prototype.unrenderBgRanges = function() {
                    this.unrenderBgSegs(), this.bgSegs = null
                }, t.prototype.getSegs = function() {
                    return (this.bgSegs || []).concat(this.fgSegs || [])
                }, t.prototype.renderFgSegs = function(t) {
                    return !1
                }, t.prototype.unrenderFgSegs = function(t) {}, t.prototype.renderBgSegs = function(t) {
                    var n = this;
                    if (!this.fillRenderer) return !1;
                    this.fillRenderer.renderSegs("bgEvent", t, {
                        getClasses: function(t) {
                            return n.getBgClasses(t.footprint.eventDef)
                        },
                        getCss: function(t) {
                            return {
                                "background-color": n.getBgColor(t.footprint.eventDef)
                            }
                        },
                        filterEl: function(t, e) {
                            return n.filterEventRenderEl(t.footprint, e)
                        }
                    })
                }, t.prototype.unrenderBgSegs = function() {
                    this.fillRenderer && this.fillRenderer.unrender("bgEvent")
                }, t.prototype.renderFgSegEls = function(r, t) {
                    var o = this;
                    void 0 === t && (t = !1);
                    var e, s = this.view.hasPublicHandlers("eventRender"),
                        n = "",
                        a = [];
                    if (r.length) {
                        for (e = 0; e < r.length; e++) this.beforeFgSegHtml(r[e]), n += this.fgSegHtml(r[e], t);
                        l(n).each(function(t, e) {
                            var n = r[t],
                                i = l(e);
                            s && (i = o.filterEventRenderEl(n.footprint, i)), i && (i.data("fc-seg", n), n.el = i, a.push(n))
                        })
                    }
                    return a
                }, t.prototype.beforeFgSegHtml = function(t) {}, t.prototype.fgSegHtml = function(t, e) {}, t.prototype.getSegClasses = function(t, e, n) {
                    var i = ["fc-event", t.isStart ? "fc-start" : "fc-not-start", t.isEnd ? "fc-end" : "fc-not-end"].concat(this.getClasses(t.footprint.eventDef));
                    return e && i.push("fc-draggable"), n && i.push("fc-resizable"), this.view.isEventDefSelected(t.footprint.eventDef) && i.push("fc-selected"), i
                }, t.prototype.filterEventRenderEl = function(t, e) {
                    var n = t.getEventLegacy(),
                        i = this.view.publiclyTrigger("eventRender", {
                            context: n,
                            args: [n, e, this.view]
                        });
                    return !1 === i ? e = null : i && !0 !== i && (e = l(i)), e
                }, t.prototype.getTimeText = function(t, e, n) {
                    return this._getTimeText(t.eventInstance.dateProfile.start, t.eventInstance.dateProfile.end, t.componentFootprint.isAllDay, e, n)
                }, t.prototype._getTimeText = function(t, e, n, i, r) {
                    return null == i && (i = this.eventTimeFormat), null == r && (r = this.displayEventEnd), this.displayEventTime && !n ? r && e ? this.view.formatRange({
                        start: t,
                        end: e
                    }, !1, i) : t.format(i) : ""
                }, t.prototype.computeEventTimeFormat = function() {
                    return this.opt("smallTimeFormat")
                }, t.prototype.computeDisplayEventTime = function() {
                    return !0
                }, t.prototype.computeDisplayEventEnd = function() {
                    return !0
                }, t.prototype.getBgClasses = function(t) {
                    var e = this.getClasses(t);
                    return e.push("fc-bgevent"), e
                }, t.prototype.getClasses = function(t) {
                    var e, n = this.getStylingObjs(t),
                        i = [];
                    for (e = 0; e < n.length; e++) i.push.apply(i, n[e].eventClassName || n[e].className || []);
                    return i
                }, t.prototype.getSkinCss = function(t) {
                    return {
                        "background-color": this.getBgColor(t),
                        "border-color": this.getBorderColor(t),
                        color: this.getTextColor(t)
                    }
                }, t.prototype.getBgColor = function(t) {
                    var e, n, i = this.getStylingObjs(t);
                    for (e = 0; e < i.length && !n; e++) n = i[e].eventBackgroundColor || i[e].eventColor || i[e].backgroundColor || i[e].color;
                    return n || (n = this.opt("eventBackgroundColor") || this.opt("eventColor")), n
                }, t.prototype.getBorderColor = function(t) {
                    var e, n, i = this.getStylingObjs(t);
                    for (e = 0; e < i.length && !n; e++) n = i[e].eventBorderColor || i[e].eventColor || i[e].borderColor || i[e].color;
                    return n || (n = this.opt("eventBorderColor") || this.opt("eventColor")), n
                }, t.prototype.getTextColor = function(t) {
                    var e, n, i = this.getStylingObjs(t);
                    for (e = 0; e < i.length && !n; e++) n = i[e].eventTextColor || i[e].textColor;
                    return n || (n = this.opt("eventTextColor")), n
                }, t.prototype.getStylingObjs = function(t) {
                    var e = this.getFallbackStylingObjs(t);
                    return e.unshift(t), e
                }, t.prototype.getFallbackStylingObjs = function(t) {
                    return [t.source]
                }, t.prototype.sortEventSegs = function(t) {
                    t.sort(u.proxy(this, "compareEventSegs"))
                }, t.prototype.compareEventSegs = function(t, e) {
                    var n = t.footprint,
                        i = e.footprint,
                        r = n.componentFootprint,
                        o = i.componentFootprint,
                        s = r.unzonedRange,
                        a = o.unzonedRange;
                    return s.startMs - a.startMs || a.endMs - a.startMs - (s.endMs - s.startMs) || o.isAllDay - r.isAllDay || u.compareByFieldSpecs(n.eventDef, i.eventDef, this.view.eventOrderSpecs, n.eventDef.miscProps, i.eventDef.miscProps)
                }, t
            }();
        e.default = i
    }, , , , , function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var s = n(10);

        function i(t) {
            return "en" !== t.locale() ? t.clone().locale("en") : t
        }
        s.newMomentProto.format = function() {
            return this._fullCalendar && arguments[0] ? c(this, arguments[0]) : this._ambigTime ? s.oldMomentFormat(i(this), "YYYY-MM-DD") : this._ambigZone ? s.oldMomentFormat(i(this), "YYYY-MM-DD[T]HH:mm:ss") : this._fullCalendar ? s.oldMomentFormat(i(this)) : s.oldMomentProto.format.apply(this, arguments)
        }, s.newMomentProto.toISOString = function() {
            return this._ambigTime ? s.oldMomentFormat(i(this), "YYYY-MM-DD") : this._ambigZone ? s.oldMomentFormat(i(this), "YYYY-MM-DD[T]HH:mm:ss") : this._fullCalendar ? s.oldMomentProto.toISOString.apply(i(this), arguments) : s.oldMomentProto.toISOString.apply(this, arguments)
        };
        var a = "\v",
            l = "",
            o = "",
            r = new RegExp(o + "([^" + o + "]*)" + o, "g"),
            u = {
                t: function(t) {
                    return s.oldMomentFormat(t, "a").charAt(0)
                },
                T: function(t) {
                    return s.oldMomentFormat(t, "A").charAt(0)
                }
            },
            d = {
                Y: {
                    value: 1,
                    unit: "year"
                },
                M: {
                    value: 2,
                    unit: "month"
                },
                W: {
                    value: 3,
                    unit: "week"
                },
                w: {
                    value: 3,
                    unit: "week"
                },
                D: {
                    value: 4,
                    unit: "day"
                },
                d: {
                    value: 4,
                    unit: "day"
                }
            };

        function c(t, e) {
            return b(m(h(e).fakeFormatString, t).join(""))
        }
        e.formatDate = c, e.formatRange = function(t, e, n, i, r) {
            return t = s.default.parseZone(t), e = s.default.parseZone(e),
                function(t, e, n, i, r) {
                    var o, s, a, l = t.sameUnits,
                        u = e.clone().stripZone(),
                        d = n.clone().stripZone(),
                        c = m(t.fakeFormatString, e),
                        p = m(t.fakeFormatString, n),
                        h = "",
                        f = "",
                        g = "",
                        v = "",
                        y = "";
                    for (o = 0; o < l.length && (!l[o] || u.isSame(d, l[o])); o++) h += c[o];
                    for (s = l.length - 1; o < s && (!l[s] || u.isSame(d, l[s])) && (s - 1 !== o || "." !== c[s]); s--) f = c[s] + f;
                    for (a = o; a <= s; a++) g += c[a], v += p[a];
                    return (g || v) && (y = r ? v + i + g : g + i + v), b(h + y + f)
                }(h(n = t.localeData().longDateFormat(n) || n), t, e, i || " - ", r)
        };
        var p = {};

        function h(t) {
            return p[t] || (p[t] = {
                fakeFormatString: function t(e) {
                    var n, i, r = [];
                    for (n = 0; n < e.length; n++) "string" == typeof(i = e[n]) ? r.push("[" + i + "]") : i.token ? i.token in u ? r.push(l + "[" + i.token + "]") : r.push(i.token) : i.maybe && r.push(o + t(i.maybe) + o);
                    return r.join(a)
                }(e = f(t)),
                sameUnits: function t(e) {
                    var n, i, r, o = [];
                    for (n = 0; n < e.length; n++)(i = e[n]).token ? (r = d[i.token.charAt(0)], o.push(r ? r.unit : "second")) : i.maybe ? o.push.apply(o, t(i.maybe)) : o.push(null);
                    return o
                }(e)
            });
            var e
        }

        function f(t) {
            for (var e, n = [], i = /\[([^\]]*)\]|\(([^\)]*)\)|(LTS|LT|(\w)\4*o?)|([^\w\[\(]+)/g; e = i.exec(t);) e[1] ? n.push.apply(n, g(e[1])) : e[2] ? n.push({
                maybe: f(e[2])
            }) : e[3] ? n.push({
                token: e[3]
            }) : e[5] && n.push.apply(n, g(e[5]));
            return n
        }

        function g(t) {
            return ". " === t ? [".", " "] : [t]
        }

        function m(t, e) {
            var n, i, r = [],
                o = s.oldMomentFormat(e, t).split(a);
            for (n = 0; n < o.length; n++)(i = o[n]).charAt(0) === l ? r.push(u[i.substring(1)](e)) : r.push(i);
            return r
        }

        function b(t) {
            return t.replace(r, function(t, e) {
                return e.match(/[1-9]/) ? e : ""
            })
        }
        e.queryMostGranularFormatUnit = function(t) {
            var e, n, i, r, o = f(t);
            for (e = 0; e < o.length; e++)(n = o[e]).token && (i = d[n.token.charAt(0)]) && (!r || i.value > r.value) && (r = i);
            return r ? r.unit : null
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(33),
            o = n(11),
            s = n(7),
            a = function(e) {
                function t() {
                    var t = e.call(this) || this;
                    return t._watchers = {}, t._props = {}, t.applyGlobalWatchers(), t.constructed(), t
                }
                return i.__extends(t, e), t.watch = function(t) {
                    for (var e = [], n = 1; n < arguments.length; n++) e[n - 1] = arguments[n];
                    this.prototype.hasOwnProperty("_globalWatchArgs") || (this.prototype._globalWatchArgs = Object.create(this.prototype._globalWatchArgs)), this.prototype._globalWatchArgs[t] = e
                }, t.prototype.constructed = function() {}, t.prototype.applyGlobalWatchers = function() {
                    var t, e = this._globalWatchArgs;
                    for (t in e) this.watch.apply(this, [t].concat(e[t]))
                }, t.prototype.has = function(t) {
                    return t in this._props
                }, t.prototype.get = function(t) {
                    return void 0 === t ? this._props : this._props[t]
                }, t.prototype.set = function(t, e) {
                    var n;
                    "string" == typeof t ? (n = {})[t] = void 0 === e ? null : e : n = t, this.setProps(n)
                }, t.prototype.reset = function(t) {
                    var e, n = this._props,
                        i = {};
                    for (e in n) i[e] = void 0;
                    for (e in t) i[e] = t[e];
                    this.setProps(i)
                }, t.prototype.unset = function(t) {
                    var e, n, i = {};
                    for (e = "string" == typeof t ? [t] : t, n = 0; n < e.length; n++) i[e[n]] = void 0;
                    this.setProps(i)
                }, t.prototype.setProps = function(t) {
                    var e, n, i = {},
                        r = 0;
                    for (e in t) "object" != typeof(n = t[e]) && n === this._props[e] || (i[e] = n, r++);
                    if (r) {
                        for (e in this.trigger("before:batchChange", i), i) n = i[e], this.trigger("before:change", e, n), this.trigger("before:change:" + e, n);
                        for (e in i) void 0 === (n = i[e]) ? delete this._props[e] : this._props[e] = n, this.trigger("change:" + e, n), this.trigger("change", e, n);
                        this.trigger("batchChange", i)
                    }
                }, t.prototype.watch = function(n, t, i, e) {
                    var r = this;
                    this.unwatch(n), this._watchers[n] = this._watchDeps(t, function(t) {
                        var e = i.call(r, t);
                        e && e.then ? (r.unset(n), e.then(function(t) {
                            r.set(n, t)
                        })) : r.set(n, e)
                    }, function(t) {
                        r.unset(n), e && e.call(r, t)
                    })
                }, t.prototype.unwatch = function(t) {
                    var e = this._watchers[t];
                    e && (delete this._watchers[t], e.teardown())
                }, t.prototype._watchDeps = function(t, s, e) {
                    var n = this,
                        a = 0,
                        l = t.length,
                        u = 0,
                        d = {},
                        i = [],
                        c = !1,
                        p = function(t, e) {
                            n.on(t, e), i.push([t, e])
                        };
                    return t.forEach(function(r) {
                        var o = !1;
                        "?" === r.charAt(0) && (r = r.substring(1), o = !0), p("before:change:" + r, function(t) {
                            1 == ++a && u === l && (c = !0, e(d), c = !1)
                        }), p("change:" + r, function(t) {
                            var e, n, i;
                            e = r, i = o, void 0 === (n = t) ? (i || void 0 === d[e] || u--, delete d[e]) : (i || void 0 !== d[e] || u++, d[e] = n), --a || u === l && (c || s(d))
                        })
                    }), t.forEach(function(t) {
                        var e = !1;
                        "?" === t.charAt(0) && (t = t.substring(1), e = !0), n.has(t) ? (d[t] = n.get(t), u++) : e && u++
                    }), u === l && s(d), {
                        teardown: function() {
                            for (var t = 0; t < i.length; t++) n.off(i[t][0], i[t][1]);
                            i = null, u === l && e()
                        },
                        flash: function() {
                            u === l && (e(), s(d))
                        }
                    }
                }, t.prototype.flash = function(t) {
                    var e = this._watchers[t];
                    e && e.flash()
                }, t
            }(r.default);
        (e.default = a).prototype._globalWatchArgs = {}, o.default.mixInto(a), s.default.mixInto(a)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(0),
            r = n(4),
            o = n(13),
            s = n(210);
        e.default = {
            parse: function(t, e) {
                return r.isTimeString(t.start) || i.isDuration(t.start) || r.isTimeString(t.end) || i.isDuration(t.end) ? s.default.parse(t, e) : o.default.parse(t, e)
            }
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var c = n(4),
            o = n(17),
            i = function() {
                function d() {
                    this.clearEnd = !1, this.forceTimed = !1, this.forceAllDay = !1
                }
                return d.createFromDiff = function(t, n, i) {
                    var e, r, o, s = t.end && !n.end,
                        a = t.isAllDay() && !n.isAllDay(),
                        l = !t.isAllDay() && n.isAllDay();

                    function u(t, e) {
                        return i ? c.diffByUnit(t, e, i) : n.isAllDay() ? c.diffDay(t, e) : c.diffDayTime(t, e)
                    }
                    return e = u(n.start, t.start), n.end && (r = u(n.unzonedRange.getEnd(), t.unzonedRange.getEnd()).subtract(e)), (o = new d).clearEnd = s, o.forceTimed = a, o.forceAllDay = l, o.setDateDelta(e), o.setEndDelta(r), o
                }, d.prototype.buildNewDateProfile = function(t, e) {
                    var n = t.start.clone(),
                        i = null,
                        r = !1;
                    return t.end && !this.clearEnd ? i = t.end.clone() : this.endDelta && !i && (i = e.getDefaultEventEnd(t.isAllDay(), n)), this.forceTimed ? (r = !0, n.hasTime() || n.time(0), i && !i.hasTime() && i.time(0)) : this.forceAllDay && (n.hasTime() && n.stripTime(), i && i.hasTime() && i.stripTime()), this.dateDelta && (r = !0, n.add(this.dateDelta), i && i.add(this.dateDelta)), this.endDelta && (r = !0, i.add(this.endDelta)), this.startDelta && (r = !0, n.add(this.startDelta)), r && (n = e.applyTimezone(n), i && (i = e.applyTimezone(i))), !i && e.opt("forceEventDuration") && (i = e.getDefaultEventEnd(t.isAllDay(), n)), new o.default(n, i, e)
                }, d.prototype.setDateDelta = function(t) {
                    t && t.valueOf() ? this.dateDelta = t : this.dateDelta = null
                }, d.prototype.setStartDelta = function(t) {
                    t && t.valueOf() ? this.startDelta = t : this.startDelta = null
                }, d.prototype.setEndDelta = function(t) {
                    t && t.valueOf() ? this.endDelta = t : this.endDelta = null
                }, d.prototype.isEmpty = function() {
                    return !(this.clearEnd || this.forceTimed || this.forceAllDay || this.dateDelta || this.startDelta || this.endDelta)
                }, d
            }();
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(213),
            r = n(214),
            o = {};
        e.defineThemeSystem = function(t, e) {
            o[t] = e
        }, e.getThemeSystemClass = function(t) {
            return t ? !0 === t ? r.default : o[t] : i.default
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(3),
            o = n(4),
            s = n(20),
            a = n(6),
            l = n(13),
            u = function(n) {
                function t(t) {
                    var e = n.call(this, t) || this;
                    return e.eventDefs = [], e
                }
                return i.__extends(t, n), t.parse = function(t, e) {
                    var n;
                    return r.isArray(t.events) ? n = t : r.isArray(t) && (n = {
                        events: t
                    }), !!n && a.default.parse.call(this, n, e)
                }, t.prototype.setRawEventDefs = function(t) {
                    this.rawEventDefs = t, this.eventDefs = this.parseEventDefs(t)
                }, t.prototype.fetch = function(t, e, n) {
                    var i, r = this.eventDefs;
                    if (null != this.currentTimezone && this.currentTimezone !== n)
                        for (i = 0; i < r.length; i++) r[i] instanceof l.default && r[i].rezone();
                    return this.currentTimezone = n, s.default.resolve(r)
                }, t.prototype.addEventDef = function(t) {
                    this.eventDefs.push(t)
                }, t.prototype.removeEventDefsById = function(e) {
                    return o.removeMatching(this.eventDefs, function(t) {
                        return t.id === e
                    })
                }, t.prototype.removeAllEventDefs = function() {
                    this.eventDefs = []
                }, t.prototype.getPrimitive = function() {
                    return this.rawEventDefs
                }, t.prototype.applyManualStandardProps = function(t) {
                    var e = n.prototype.applyManualStandardProps.call(this, t);
                    return this.setRawEventDefs(t.events), e
                }, t
            }(a.default);
        (e.default = u).defineStandardProps({
            events: !1
        })
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var a = n(3),
            i = n(4),
            r = function() {
                function t(t) {
                    this.isHorizontal = !1, this.isVertical = !1, this.els = a(t.els), this.isHorizontal = t.isHorizontal, this.isVertical = t.isVertical, this.forcedOffsetParentEl = t.offsetParent ? a(t.offsetParent) : null
                }
                return t.prototype.build = function() {
                    var t = this.forcedOffsetParentEl;
                    !t && 0 < this.els.length && (t = this.els.eq(0).offsetParent()), this.origin = t ? t.offset() : null, this.boundingRect = this.queryBoundingRect(), this.isHorizontal && this.buildElHorizontals(), this.isVertical && this.buildElVerticals()
                }, t.prototype.clear = function() {
                    this.origin = null, this.boundingRect = null, this.lefts = null, this.rights = null, this.tops = null, this.bottoms = null
                }, t.prototype.ensureBuilt = function() {
                    this.origin || this.build()
                }, t.prototype.buildElHorizontals = function() {
                    var o = [],
                        s = [];
                    this.els.each(function(t, e) {
                        var n = a(e),
                            i = n.offset().left,
                            r = n.outerWidth();
                        o.push(i), s.push(i + r)
                    }), this.lefts = o, this.rights = s
                }, t.prototype.buildElVerticals = function() {
                    var o = [],
                        s = [];
                    this.els.each(function(t, e) {
                        var n = a(e),
                            i = n.offset().top,
                            r = n.outerHeight();
                        o.push(i), s.push(i + r)
                    }), this.tops = o, this.bottoms = s
                }, t.prototype.getHorizontalIndex = function(t) {
                    this.ensureBuilt();
                    var e, n = this.lefts,
                        i = this.rights,
                        r = n.length;
                    for (e = 0; e < r; e++)
                        if (t >= n[e] && t < i[e]) return e
                }, t.prototype.getVerticalIndex = function(t) {
                    this.ensureBuilt();
                    var e, n = this.tops,
                        i = this.bottoms,
                        r = n.length;
                    for (e = 0; e < r; e++)
                        if (t >= n[e] && t < i[e]) return e
                }, t.prototype.getLeftOffset = function(t) {
                    return this.ensureBuilt(), this.lefts[t]
                }, t.prototype.getLeftPosition = function(t) {
                    return this.ensureBuilt(), this.lefts[t] - this.origin.left
                }, t.prototype.getRightOffset = function(t) {
                    return this.ensureBuilt(), this.rights[t]
                }, t.prototype.getRightPosition = function(t) {
                    return this.ensureBuilt(), this.rights[t] - this.origin.left
                }, t.prototype.getWidth = function(t) {
                    return this.ensureBuilt(), this.rights[t] - this.lefts[t]
                }, t.prototype.getTopOffset = function(t) {
                    return this.ensureBuilt(), this.tops[t]
                }, t.prototype.getTopPosition = function(t) {
                    return this.ensureBuilt(), this.tops[t] - this.origin.top
                }, t.prototype.getBottomOffset = function(t) {
                    return this.ensureBuilt(), this.bottoms[t]
                }, t.prototype.getBottomPosition = function(t) {
                    return this.ensureBuilt(), this.bottoms[t] - this.origin.top
                }, t.prototype.getHeight = function(t) {
                    return this.ensureBuilt(), this.bottoms[t] - this.tops[t]
                }, t.prototype.queryBoundingRect = function() {
                    var t;
                    return 0 < this.els.length && !(t = i.getScrollParent(this.els.eq(0))).is(document) ? i.getClientRect(t) : null
                }, t.prototype.isPointInBounds = function(t, e) {
                    return this.isLeftInBounds(t) && this.isTopInBounds(e)
                }, t.prototype.isLeftInBounds = function(t) {
                    return !this.boundingRect || t >= this.boundingRect.left && t < this.boundingRect.right
                }, t.prototype.isTopInBounds = function(t) {
                    return !this.boundingRect || t >= this.boundingRect.top && t < this.boundingRect.bottom
                }, t
            }();
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(3),
            u = n(4),
            r = n(7),
            o = n(21),
            s = function() {
                function t(t) {
                    this.isInteracting = !1, this.isDistanceSurpassed = !1, this.isDelayEnded = !1, this.isDragging = !1, this.isTouch = !1, this.isGeneric = !1, this.shouldCancelTouchScroll = !0, this.scrollAlwaysKills = !1, this.isAutoScroll = !1, this.scrollSensitivity = 30, this.scrollSpeed = 200, this.scrollIntervalMs = 50, this.options = t || {}
                }
                return t.prototype.startInteraction = function(t, e) {
                    if (void 0 === e && (e = {}), "mousedown" === t.type) {
                        if (o.default.get().shouldIgnoreMouse()) return;
                        if (!u.isPrimaryMouseButton(t)) return;
                        t.preventDefault()
                    }
                    this.isInteracting || (this.delay = u.firstDefined(e.delay, this.options.delay, 0), this.minDistance = u.firstDefined(e.distance, this.options.distance, 0), this.subjectEl = this.options.subjectEl, u.preventSelection(i("body")), this.isInteracting = !0, this.isTouch = u.getEvIsTouch(t), this.isGeneric = "dragstart" === t.type, this.isDelayEnded = !1, this.isDistanceSurpassed = !1, this.originX = u.getEvX(t), this.originY = u.getEvY(t), this.scrollEl = u.getScrollParent(i(t.target)), this.bindHandlers(), this.initAutoScroll(), this.handleInteractionStart(t), this.startDelay(t), this.minDistance || this.handleDistanceSurpassed(t))
                }, t.prototype.handleInteractionStart = function(t) {
                    this.trigger("interactionStart", t)
                }, t.prototype.endInteraction = function(t, e) {
                    this.isInteracting && (this.endDrag(t), this.delayTimeoutId && (clearTimeout(this.delayTimeoutId), this.delayTimeoutId = null), this.destroyAutoScroll(), this.unbindHandlers(), this.isInteracting = !1, this.handleInteractionEnd(t, e), u.allowSelection(i("body")))
                }, t.prototype.handleInteractionEnd = function(t, e) {
                    this.trigger("interactionEnd", t, e || !1)
                }, t.prototype.bindHandlers = function() {
                    var t = o.default.get();
                    this.isGeneric ? this.listenTo(i(document), {
                        drag: this.handleMove,
                        dragstop: this.endInteraction
                    }) : this.isTouch ? this.listenTo(t, {
                        touchmove: this.handleTouchMove,
                        touchend: this.endInteraction,
                        scroll: this.handleTouchScroll
                    }) : this.listenTo(t, {
                        mousemove: this.handleMouseMove,
                        mouseup: this.endInteraction
                    }), this.listenTo(t, {
                        selectstart: u.preventDefault,
                        contextmenu: u.preventDefault
                    })
                }, t.prototype.unbindHandlers = function() {
                    this.stopListeningTo(o.default.get()), this.stopListeningTo(i(document))
                }, t.prototype.startDrag = function(t, e) {
                    this.startInteraction(t, e), this.isDragging || (this.isDragging = !0, this.handleDragStart(t))
                }, t.prototype.handleDragStart = function(t) {
                    this.trigger("dragStart", t)
                }, t.prototype.handleMove = function(t) {
                    var e = u.getEvX(t) - this.originX,
                        n = u.getEvY(t) - this.originY,
                        i = this.minDistance;
                    this.isDistanceSurpassed || i * i <= e * e + n * n && this.handleDistanceSurpassed(t), this.isDragging && this.handleDrag(e, n, t)
                }, t.prototype.handleDrag = function(t, e, n) {
                    this.trigger("drag", t, e, n), this.updateAutoScroll(n)
                }, t.prototype.endDrag = function(t) {
                    this.isDragging && (this.isDragging = !1, this.handleDragEnd(t))
                }, t.prototype.handleDragEnd = function(t) {
                    this.trigger("dragEnd", t)
                }, t.prototype.startDelay = function(t) {
                    var e = this;
                    this.delay ? this.delayTimeoutId = setTimeout(function() {
                        e.handleDelayEnd(t)
                    }, this.delay) : this.handleDelayEnd(t)
                }, t.prototype.handleDelayEnd = function(t) {
                    this.isDelayEnded = !0, this.isDistanceSurpassed && this.startDrag(t)
                }, t.prototype.handleDistanceSurpassed = function(t) {
                    this.isDistanceSurpassed = !0, this.isDelayEnded && this.startDrag(t)
                }, t.prototype.handleTouchMove = function(t) {
                    this.isDragging && this.shouldCancelTouchScroll && t.preventDefault(), this.handleMove(t)
                }, t.prototype.handleMouseMove = function(t) {
                    this.handleMove(t)
                }, t.prototype.handleTouchScroll = function(t) {
                    this.isDragging && !this.scrollAlwaysKills || this.endInteraction(t, !0)
                }, t.prototype.trigger = function(t) {
                    for (var e = [], n = 1; n < arguments.length; n++) e[n - 1] = arguments[n];
                    this.options[t] && this.options[t].apply(this, e), this["_" + t] && this["_" + t].apply(this, e)
                }, t.prototype.initAutoScroll = function() {
                    var t = this.scrollEl;
                    this.isAutoScroll = this.options.scroll && t && !t.is(window) && !t.is(document), this.isAutoScroll && this.listenTo(t, "scroll", u.debounce(this.handleDebouncedScroll, 100))
                }, t.prototype.destroyAutoScroll = function() {
                    this.endAutoScroll(), this.isAutoScroll && this.stopListeningTo(this.scrollEl, "scroll")
                }, t.prototype.computeScrollBounds = function() {
                    this.isAutoScroll && (this.scrollBounds = u.getOuterRect(this.scrollEl))
                }, t.prototype.updateAutoScroll = function(t) {
                    var e, n, i, r, o = this.scrollSensitivity,
                        s = this.scrollBounds,
                        a = 0,
                        l = 0;
                    s && (e = (o - (u.getEvY(t) - s.top)) / o, n = (o - (s.bottom - u.getEvY(t))) / o, i = (o - (u.getEvX(t) - s.left)) / o, r = (o - (s.right - u.getEvX(t))) / o, 0 <= e && e <= 1 ? a = e * this.scrollSpeed * -1 : 0 <= n && n <= 1 && (a = n * this.scrollSpeed), 0 <= i && i <= 1 ? l = i * this.scrollSpeed * -1 : 0 <= r && r <= 1 && (l = r * this.scrollSpeed)), this.setScrollVel(a, l)
                }, t.prototype.setScrollVel = function(t, e) {
                    this.scrollTopVel = t, this.scrollLeftVel = e, this.constrainScrollVel(), !this.scrollTopVel && !this.scrollLeftVel || this.scrollIntervalId || (this.scrollIntervalId = setInterval(u.proxy(this, "scrollIntervalFunc"), this.scrollIntervalMs))
                }, t.prototype.constrainScrollVel = function() {
                    var t = this.scrollEl;
                    this.scrollTopVel < 0 ? t.scrollTop() <= 0 && (this.scrollTopVel = 0) : 0 < this.scrollTopVel && t.scrollTop() + t[0].clientHeight >= t[0].scrollHeight && (this.scrollTopVel = 0), this.scrollLeftVel < 0 ? t.scrollLeft() <= 0 && (this.scrollLeftVel = 0) : 0 < this.scrollLeftVel && t.scrollLeft() + t[0].clientWidth >= t[0].scrollWidth && (this.scrollLeftVel = 0)
                }, t.prototype.scrollIntervalFunc = function() {
                    var t = this.scrollEl,
                        e = this.scrollIntervalMs / 1e3;
                    this.scrollTopVel && t.scrollTop(t.scrollTop() + this.scrollTopVel * e), this.scrollLeftVel && t.scrollLeft(t.scrollLeft() + this.scrollLeftVel * e), this.constrainScrollVel(), this.scrollTopVel || this.scrollLeftVel || this.endAutoScroll()
                }, t.prototype.endAutoScroll = function() {
                    this.scrollIntervalId && (clearInterval(this.scrollIntervalId), this.scrollIntervalId = null, this.handleScrollEnd())
                }, t.prototype.handleDebouncedScroll = function() {
                    this.scrollIntervalId || this.handleScrollEnd()
                }, t.prototype.handleScrollEnd = function() {}, t
            }();
        e.default = s, r.default.mixInto(s)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            l = n(4),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.updateDayTable = function() {
                    for (var t, e, n, i = this.view, r = i.calendar, o = r.msToUtcMoment(this.dateProfile.renderUnzonedRange.startMs, !0), s = r.msToUtcMoment(this.dateProfile.renderUnzonedRange.endMs, !0), a = -1, l = [], u = []; o.isBefore(s);) i.isHiddenDay(o) ? l.push(a + .5) : (a++, l.push(a), u.push(o.clone())), o.add(1, "days");
                    if (this.breakOnWeeks) {
                        for (e = u[0].day(), t = 1; t < u.length && u[t].day() !== e; t++);
                        n = Math.ceil(u.length / t)
                    } else n = 1, t = u.length;
                    this.dayDates = u, this.dayIndices = l, this.daysPerRow = t, this.rowCnt = n, this.updateDayTableCols()
                }, e.prototype.updateDayTableCols = function() {
                    this.colCnt = this.computeColCnt(), this.colHeadFormat = this.opt("columnHeaderFormat") || this.opt("columnFormat") || this.computeColHeadFormat()
                }, e.prototype.computeColCnt = function() {
                    return this.daysPerRow
                }, e.prototype.getCellDate = function(t, e) {
                    return this.dayDates[this.getCellDayIndex(t, e)].clone()
                }, e.prototype.getCellRange = function(t, e) {
                    var n = this.getCellDate(t, e);
                    return {
                        start: n,
                        end: n.clone().add(1, "days")
                    }
                }, e.prototype.getCellDayIndex = function(t, e) {
                    return t * this.daysPerRow + this.getColDayIndex(e)
                }, e.prototype.getColDayIndex = function(t) {
                    return this.isRTL ? this.colCnt - 1 - t : t
                }, e.prototype.getDateDayIndex = function(t) {
                    var e = this.dayIndices,
                        n = t.diff(this.dayDates[0], "days");
                    return n < 0 ? e[0] - 1 : n >= e.length ? e[e.length - 1] + 1 : e[n]
                }, e.prototype.computeColHeadFormat = function() {
                    return 1 < this.rowCnt || 10 < this.colCnt ? "ddd" : 1 < this.colCnt ? this.opt("dayOfMonthFormat") : "dddd"
                }, e.prototype.sliceRangeByRow = function(t) {
                    var e, n, i, r, o, s = this.daysPerRow,
                        a = this.view.computeDayRange(t),
                        l = this.getDateDayIndex(a.start),
                        u = this.getDateDayIndex(a.end.clone().subtract(1, "days")),
                        d = [];
                    for (e = 0; e < this.rowCnt; e++) i = (n = e * s) + s - 1, r = Math.max(l, n), o = Math.min(u, i), (r = Math.ceil(r)) <= (o = Math.floor(o)) && d.push({
                        row: e,
                        firstRowDayIndex: r - n,
                        lastRowDayIndex: o - n,
                        isStart: r === l,
                        isEnd: o === u
                    });
                    return d
                }, e.prototype.sliceRangeByDay = function(t) {
                    var e, n, i, r, o, s, a = this.daysPerRow,
                        l = this.view.computeDayRange(t),
                        u = this.getDateDayIndex(l.start),
                        d = this.getDateDayIndex(l.end.clone().subtract(1, "days")),
                        c = [];
                    for (e = 0; e < this.rowCnt; e++)
                        for (i = (n = e * a) + a - 1, r = n; r <= i; r++) o = Math.max(u, r), s = Math.min(d, r), (o = Math.ceil(o)) <= (s = Math.floor(s)) && c.push({
                            row: e,
                            firstRowDayIndex: o - n,
                            lastRowDayIndex: s - n,
                            isStart: o === u,
                            isEnd: s === d
                        });
                    return c
                }, e.prototype.renderHeadHtml = function() {
                    var t = this.view.calendar.theme;
                    return '<div class="fc-row ' + t.getClass("headerRow") + '"><table class="' + t.getClass("tableGrid") + '"><thead>' + this.renderHeadTrHtml() + "</thead></table></div>"
                }, e.prototype.renderHeadIntroHtml = function() {
                    return this.renderIntroHtml()
                }, e.prototype.renderHeadTrHtml = function() {
                    return "<tr>" + (this.isRTL ? "" : this.renderHeadIntroHtml()) + this.renderHeadDateCellsHtml() + (this.isRTL ? this.renderHeadIntroHtml() : "") + "</tr>"
                }, e.prototype.renderHeadDateCellsHtml = function() {
                    var t, e, n = [];
                    for (t = 0; t < this.colCnt; t++) e = this.getCellDate(0, t), n.push(this.renderHeadDateCellHtml(e));
                    return n.join("")
                }, e.prototype.renderHeadDateCellHtml = function(t, e, n) {
                    var i, r = this,
                        o = r.view,
                        s = r.dateProfile.activeUnzonedRange.containsDate(t),
                        a = ["fc-day-header", o.calendar.theme.getClass("widgetHeader")];
                    return i = "function" == typeof r.opt("columnHeaderHtml") ? r.opt("columnHeaderHtml")(t) : "function" == typeof r.opt("columnHeaderText") ? l.htmlEscape(r.opt("columnHeaderText")(t)) : l.htmlEscape(t.format(r.colHeadFormat)), 1 === r.rowCnt ? a = a.concat(r.getDayClasses(t, !0)) : a.push("fc-" + l.dayIDs[t.day()]), '<th class="' + a.join(" ") + '"' + (1 === (s && r.rowCnt) ? ' data-date="' + t.format("YYYY-MM-DD") + '"' : "") + (1 < e ? ' colspan="' + e + '"' : "") + (n ? " " + n : "") + ">" + (s ? o.buildGotoAnchorHtml({
                        date: t,
                        forceOff: 1 < r.rowCnt || 1 === r.colCnt
                    }, i) : i) + "</th>"
                }, e.prototype.renderBgTrHtml = function(t) {
                    return "<tr>" + (this.isRTL ? "" : this.renderBgIntroHtml(t)) + this.renderBgCellsHtml(t) + (this.isRTL ? this.renderBgIntroHtml(t) : "") + "</tr>"
                }, e.prototype.renderBgIntroHtml = function(t) {
                    return this.renderIntroHtml()
                }, e.prototype.renderBgCellsHtml = function(t) {
                    var e, n, i = [];
                    for (e = 0; e < this.colCnt; e++) n = this.getCellDate(t, e), i.push(this.renderBgCellHtml(n));
                    return i.join("")
                }, e.prototype.renderBgCellHtml = function(t, e) {
                    var n = this.view,
                        i = this.dateProfile.activeUnzonedRange.containsDate(t),
                        r = this.getDayClasses(t);
                    return r.unshift("fc-day", n.calendar.theme.getClass("widgetContent")), '<td class="' + r.join(" ") + '"' + (i ? ' data-date="' + t.format("YYYY-MM-DD") + '"' : "") + (e ? " " + e : "") + "></td>"
                }, e.prototype.renderIntroHtml = function() {}, e.prototype.bookendCells = function(t) {
                    var e = this.renderIntroHtml();
                    e && (this.isRTL ? t.append(e) : t.prepend(e))
                }, e
            }(n(14).default);
        e.default = r
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function() {
            function t(t, e) {
                this.component = t, this.fillRenderer = e
            }
            return t.prototype.render = function(t) {
                var e = this.component,
                    n = e._getDateProfile().activeUnzonedRange,
                    i = t.buildEventInstanceGroup(e.hasAllDayBusinessHours, n),
                    r = i ? e.eventRangesToEventFootprints(i.sliceRenderRanges(n)) : [];
                this.renderEventFootprints(r)
            }, t.prototype.renderEventFootprints = function(t) {
                var e = this.component.eventFootprintsToSegs(t);
                this.renderSegs(e), this.segs = e
            }, t.prototype.renderSegs = function(t) {
                this.fillRenderer && this.fillRenderer.renderSegs("businessHours", t, {
                    getClasses: function(t) {
                        return ["fc-nonbusiness", "fc-bgevent"]
                    }
                })
            }, t.prototype.unrender = function() {
                this.fillRenderer && this.fillRenderer.unrender("businessHours"), this.segs = null
            }, t.prototype.getSegs = function() {
                return this.segs || []
            }, t
        }();
        e.default = n
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var l = n(3),
            o = n(4),
            i = function() {
                function t(t) {
                    this.fillSegTag = "div", this.component = t, this.elsByFill = {}
                }
                return t.prototype.renderFootprint = function(t, e, n) {
                    this.renderSegs(t, this.component.componentFootprintToSegs(e), n)
                }, t.prototype.renderSegs = function(t, e, n) {
                    var i;
                    return e = this.buildSegEls(t, e, n), (i = this.attachSegEls(t, e)) && this.reportEls(t, i), e
                }, t.prototype.unrender = function(t) {
                    var e = this.elsByFill[t];
                    e && (e.remove(), delete this.elsByFill[t])
                }, t.prototype.buildSegEls = function(t, r, o) {
                    var e, s = this,
                        n = "",
                        a = [];
                    if (r.length) {
                        for (e = 0; e < r.length; e++) n += this.buildSegHtml(t, r[e], o);
                        l(n).each(function(t, e) {
                            var n = r[t],
                                i = l(e);
                            o.filterEl && (i = o.filterEl(n, i)), i && (i = l(i)).is(s.fillSegTag) && (n.el = i, a.push(n))
                        })
                    }
                    return a
                }, t.prototype.buildSegHtml = function(t, e, n) {
                    var i = n.getClasses ? n.getClasses(e) : [],
                        r = o.cssToStr(n.getCss ? n.getCss(e) : {});
                    return "<" + this.fillSegTag + (i.length ? ' class="' + i.join(" ") + '"' : "") + (r ? ' style="' + r + '"' : "") + " />"
                }, t.prototype.attachSegEls = function(t, e) {}, t.prototype.reportEls = function(t, e) {
                    this.elsByFill[t] ? this.elsByFill[t] = this.elsByFill[t].add(e) : this.elsByFill[t] = l(e)
                }, t
            }();
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var o = n(13),
            s = n(36),
            a = n(6),
            i = function() {
                function t(t, e) {
                    this.view = t._getView(), this.component = t, this.eventRenderer = e
                }
                return t.prototype.renderComponentFootprint = function(t) {
                    this.renderEventFootprints([this.fabricateEventFootprint(t)])
                }, t.prototype.renderEventDraggingFootprints = function(t, e, n) {
                    this.renderEventFootprints(t, e, "fc-dragging", n ? null : this.view.opt("dragOpacity"))
                }, t.prototype.renderEventResizingFootprints = function(t, e, n) {
                    this.renderEventFootprints(t, e, "fc-resizing")
                }, t.prototype.renderEventFootprints = function(t, e, n, i) {
                    var r, o = this.component.eventFootprintsToSegs(t),
                        s = "fc-helper " + (n || "");
                    for (o = this.eventRenderer.renderFgSegEls(o), r = 0; r < o.length; r++) o[r].el.addClass(s);
                    if (null != i)
                        for (r = 0; r < o.length; r++) o[r].el.css("opacity", i);
                    this.helperEls = this.renderSegs(o, e)
                }, t.prototype.renderSegs = function(t, e) {}, t.prototype.unrender = function() {
                    this.helperEls && (this.helperEls.remove(), this.helperEls = null)
                }, t.prototype.fabricateEventFootprint = function(t) {
                    var e, n = this.view.calendar,
                        i = n.footprintToDateProfile(t),
                        r = new o.default(new a.default(n));
                    return r.dateProfile = i, e = r.buildInstance(), new s.default(t, r, e)
                }, t
            }();
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(21),
            o = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.bindToEl = function(t) {
                    var e = this.component;
                    e.bindSegHandlerToEl(t, "click", this.handleClick.bind(this)), e.bindSegHandlerToEl(t, "mouseenter", this.handleMouseover.bind(this)), e.bindSegHandlerToEl(t, "mouseleave", this.handleMouseout.bind(this))
                }, e.prototype.handleClick = function(t, e) {
                    !1 === this.component.publiclyTrigger("eventClick", {
                        context: t.el[0],
                        args: [t.footprint.getEventLegacy(), e, this.view]
                    }) && e.preventDefault()
                }, e.prototype.handleMouseover = function(t, e) {
                    r.default.get().shouldIgnoreMouse() || this.mousedOverSeg || (this.mousedOverSeg = t, this.view.isEventDefResizable(t.footprint.eventDef) && t.el.addClass("fc-allow-mouse-resize"), this.component.publiclyTrigger("eventMouseover", {
                        context: t.el[0],
                        args: [t.footprint.getEventLegacy(), e, this.view]
                    }))
                }, e.prototype.handleMouseout = function(t, e) {
                    this.mousedOverSeg && (this.mousedOverSeg = null, this.view.isEventDefResizable(t.footprint.eventDef) && t.el.removeClass("fc-allow-mouse-resize"), this.component.publiclyTrigger("eventMouseout", {
                        context: t.el[0],
                        args: [t.footprint.getEventLegacy(), e || {}, this.view]
                    }))
                }, e.prototype.end = function() {
                    this.mousedOverSeg && this.handleMouseout(this.mousedOverSeg)
                }, e
            }(n(15).default);
        e.default = o
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(14),
            o = n(245),
            s = n(225),
            a = n(59),
            l = n(224),
            u = n(223),
            d = n(222),
            c = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e
            }(r.default);
        (e.default = c).prototype.dateClickingClass = o.default, c.prototype.dateSelectingClass = s.default, c.prototype.eventPointingClass = a.default, c.prototype.eventDraggingClass = l.default, c.prototype.eventResizingClass = u.default, c.prototype.externalDroppingClass = d.default
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            E = n(3),
            l = n(4),
            s = n(53),
            u = n(249),
            d = n(5),
            c = n(12),
            p = n(36),
            r = n(56),
            o = n(60),
            a = n(40),
            h = n(55),
            f = n(250),
            g = n(251),
            v = n(252),
            y = function(n) {
                function t(t) {
                    var e = n.call(this, t) || this;
                    return e.cellWeekNumbersVisible = !1, e.bottomCoordPadding = 0, e.isRigid = !1, e.hasAllDayBusinessHours = !0, e
                }
                return i.__extends(t, n), t.prototype.componentFootprintToSegs = function(t) {
                    var e, n, i = this.sliceRangeByRow(t.unzonedRange);
                    for (e = 0; e < i.length; e++) n = i[e], this.isRTL ? (n.leftCol = this.daysPerRow - 1 - n.lastRowDayIndex, n.rightCol = this.daysPerRow - 1 - n.firstRowDayIndex) : (n.leftCol = n.firstRowDayIndex, n.rightCol = n.lastRowDayIndex);
                    return i
                }, t.prototype.renderDates = function(t) {
                    this.dateProfile = t, this.updateDayTable(), this.renderGrid()
                }, t.prototype.unrenderDates = function() {
                    this.removeSegPopover()
                }, t.prototype.renderGrid = function() {
                    var t, e, n = this.view,
                        i = this.rowCnt,
                        r = this.colCnt,
                        o = "";
                    for (this.headContainerEl && this.headContainerEl.html(this.renderHeadHtml()), t = 0; t < i; t++) o += this.renderDayRowHtml(t, this.isRigid);
                    for (this.el.html(o), this.rowEls = this.el.find(".fc-row"), this.cellEls = this.el.find(".fc-day, .fc-disabled-day"), this.rowCoordCache = new s.default({
                            els: this.rowEls,
                            isVertical: !0
                        }), this.colCoordCache = new s.default({
                            els: this.cellEls.slice(0, this.colCnt),
                            isHorizontal: !0
                        }), t = 0; t < i; t++)
                        for (e = 0; e < r; e++) this.publiclyTrigger("dayRender", {
                            context: n,
                            args: [this.getCellDate(t, e), this.getCellEl(t, e), n]
                        })
                }, t.prototype.renderDayRowHtml = function(t, e) {
                    var n = this.view.calendar.theme,
                        i = ["fc-row", "fc-week", n.getClass("dayRow")];
                    return e && i.push("fc-rigid"), '<div class="' + i.join(" ") + '"><div class="fc-bg"><table class="' + n.getClass("tableGrid") + '">' + this.renderBgTrHtml(t) + '</table></div><div class="fc-content-skeleton"><table>' + (this.getIsNumbersVisible() ? "<thead>" + this.renderNumberTrHtml(t) + "</thead>" : "") + "</table></div></div>"
                }, t.prototype.getIsNumbersVisible = function() {
                    return this.getIsDayNumbersVisible() || this.cellWeekNumbersVisible
                }, t.prototype.getIsDayNumbersVisible = function() {
                    return 1 < this.rowCnt
                }, t.prototype.renderNumberTrHtml = function(t) {
                    return "<tr>" + (this.isRTL ? "" : this.renderNumberIntroHtml(t)) + this.renderNumberCellsHtml(t) + (this.isRTL ? this.renderNumberIntroHtml(t) : "") + "</tr>"
                }, t.prototype.renderNumberIntroHtml = function(t) {
                    return this.renderIntroHtml()
                }, t.prototype.renderNumberCellsHtml = function(t) {
                    var e, n, i = [];
                    for (e = 0; e < this.colCnt; e++) n = this.getCellDate(t, e), i.push(this.renderNumberCellHtml(n));
                    return i.join("")
                }, t.prototype.renderNumberCellHtml = function(t) {
                    var e, n, i = this.view,
                        r = "",
                        o = this.dateProfile.activeUnzonedRange.containsDate(t),
                        s = this.getIsDayNumbersVisible() && o;
                    return s || this.cellWeekNumbersVisible ? ((e = this.getDayClasses(t)).unshift("fc-day-top"), this.cellWeekNumbersVisible && (n = "ISO" === t._locale._fullCalendar_weekCalc ? 1 : t._locale.firstDayOfWeek()), r += '<td class="' + e.join(" ") + '"' + (o ? ' data-date="' + t.format() + '"' : "") + ">", this.cellWeekNumbersVisible && t.day() === n && (r += i.buildGotoAnchorHtml({
                        date: t,
                        type: "week"
                    }, {
                        class: "fc-week-number"
                    }, t.format("w"))), s && (r += i.buildGotoAnchorHtml(t, {
                        class: "fc-day-number"
                    }, t.format("D"))), r += "</td>") : "<td/>"
                }, t.prototype.prepareHits = function() {
                    this.colCoordCache.build(), this.rowCoordCache.build(), this.rowCoordCache.bottoms[this.rowCnt - 1] += this.bottomCoordPadding
                }, t.prototype.releaseHits = function() {
                    this.colCoordCache.clear(), this.rowCoordCache.clear()
                }, t.prototype.queryHit = function(t, e) {
                    if (this.colCoordCache.isLeftInBounds(t) && this.rowCoordCache.isTopInBounds(e)) {
                        var n = this.colCoordCache.getHorizontalIndex(t),
                            i = this.rowCoordCache.getVerticalIndex(e);
                        if (null != i && null != n) return this.getCellHit(i, n)
                    }
                }, t.prototype.getHitFootprint = function(t) {
                    var e = this.getCellRange(t.row, t.col);
                    return new c.default(new d.default(e.start, e.end), !0)
                }, t.prototype.getHitEl = function(t) {
                    return this.getCellEl(t.row, t.col)
                }, t.prototype.getCellHit = function(t, e) {
                    return {
                        row: t,
                        col: e,
                        component: this,
                        left: this.colCoordCache.getLeftOffset(e),
                        right: this.colCoordCache.getRightOffset(e),
                        top: this.rowCoordCache.getTopOffset(t),
                        bottom: this.rowCoordCache.getBottomOffset(t)
                    }
                }, t.prototype.getCellEl = function(t, e) {
                    return this.cellEls.eq(t * this.colCnt + e)
                }, t.prototype.executeEventUnrender = function() {
                    this.removeSegPopover(), n.prototype.executeEventUnrender.call(this)
                }, t.prototype.getOwnEventSegs = function() {
                    return n.prototype.getOwnEventSegs.call(this).concat(this.popoverSegs || [])
                }, t.prototype.renderDrag = function(t, e, n) {
                    var i;
                    for (i = 0; i < t.length; i++) this.renderHighlight(t[i].componentFootprint);
                    if (t.length && e && e.component !== this) return this.helperRenderer.renderEventDraggingFootprints(t, e, n), !0
                }, t.prototype.unrenderDrag = function() {
                    this.unrenderHighlight(), this.helperRenderer.unrender()
                }, t.prototype.renderEventResize = function(t, e, n) {
                    var i;
                    for (i = 0; i < t.length; i++) this.renderHighlight(t[i].componentFootprint);
                    this.helperRenderer.renderEventResizingFootprints(t, e, n)
                }, t.prototype.unrenderEventResize = function() {
                    this.unrenderHighlight(), this.helperRenderer.unrender()
                }, t.prototype.removeSegPopover = function() {
                    this.segPopover && this.segPopover.hide()
                }, t.prototype.limitRows = function(t) {
                    var e, n, i = this.eventRenderer.rowStructs || [];
                    for (e = 0; e < i.length; e++) this.unlimitRow(e), !1 !== (n = !!t && ("number" == typeof t ? t : this.computeRowLevelLimit(e))) && this.limitRow(e, n)
                }, t.prototype.computeRowLevelLimit = function(t) {
                    var e, n, i, r = this.rowEls.eq(t).height(),
                        o = this.eventRenderer.rowStructs[t].tbodyEl.children();

                    function s(t, e) {
                        i = Math.max(i, E(e).outerHeight())
                    }
                    for (e = 0; e < o.length; e++)
                        if (n = o.eq(e).removeClass("fc-limited"), i = 0, n.find("> td > :first-child").each(s), n.position().top + i > r) return e;
                    return !1
                }, t.prototype.limitRow = function(e, n) {
                    var t, i, r, o, s, a, l, u, d, c, p, h, f, g, v, y = this,
                        m = this.eventRenderer.rowStructs[e],
                        b = [],
                        w = 0,
                        D = function(t) {
                            for (; w < t;)(a = y.getCellSegs(e, w, n)).length && (d = i[n - 1][w], v = y.renderMoreLink(e, w, a), g = E("<div/>").append(v), d.append(g), b.push(g[0])), w++
                        };
                    if (n && n < m.segLevels.length) {
                        for (t = m.segLevels[n - 1], i = m.cellMatrix, r = m.tbodyEl.children().slice(n).addClass("fc-limited").get(), o = 0; o < t.length; o++) {
                            for (D((s = t[o]).leftCol), u = [], l = 0; w <= s.rightCol;) a = this.getCellSegs(e, w, n), u.push(a), l += a.length, w++;
                            if (l) {
                                for (c = (d = i[n - 1][s.leftCol]).attr("rowspan") || 1, p = [], h = 0; h < u.length; h++) f = E('<td class="fc-more-cell"/>').attr("rowspan", c), a = u[h], v = this.renderMoreLink(e, s.leftCol + h, [s].concat(a)), g = E("<div/>").append(v), f.append(g), p.push(f[0]), b.push(f[0]);
                                d.addClass("fc-limited").after(E(p)), r.push(d[0])
                            }
                        }
                        D(this.colCnt), m.moreEls = E(b), m.limitedEls = E(r)
                    }
                }, t.prototype.unlimitRow = function(t) {
                    var e = this.eventRenderer.rowStructs[t];
                    e.moreEls && (e.moreEls.remove(), e.moreEls = null), e.limitedEls && (e.limitedEls.removeClass("fc-limited"), e.limitedEls = null)
                }, t.prototype.renderMoreLink = function(l, u, d) {
                    var c = this,
                        p = this.view;
                    return E('<a class="fc-more"/>').text(this.getMoreLinkText(d.length)).on("click", function(t) {
                        var e = c.opt("eventLimitClick"),
                            n = c.getCellDate(l, u),
                            i = E(t.currentTarget),
                            r = c.getCellEl(l, u),
                            o = c.getCellSegs(l, u),
                            s = c.resliceDaySegs(o, n),
                            a = c.resliceDaySegs(d, n);
                        "function" == typeof e && (e = c.publiclyTrigger("eventLimitClick", {
                            context: p,
                            args: [{
                                date: n.clone(),
                                dayEl: r,
                                moreEl: i,
                                segs: s,
                                hiddenSegs: a
                            }, t, p]
                        })), "popover" === e ? c.showSegPopover(l, u, i, s) : "string" == typeof e && p.calendar.zoomTo(n, e)
                    })
                }, t.prototype.showSegPopover = function(t, e, n, i) {
                    var r, o, s = this,
                        a = this.view,
                        l = n.parent();
                    r = 1 === this.rowCnt ? a.el : this.rowEls.eq(t), o = {
                        className: "fc-more-popover " + a.calendar.theme.getClass("popover"),
                        content: this.renderSegPopoverContent(t, e, i),
                        parentEl: a.el,
                        top: r.offset().top,
                        autoHide: !0,
                        viewportConstrain: this.opt("popoverViewportConstrain"),
                        hide: function() {
                            s.popoverSegs && s.triggerBeforeEventSegsDestroyed(s.popoverSegs), s.segPopover.removeElement(), s.segPopover = null, s.popoverSegs = null
                        }
                    }, this.isRTL ? o.right = l.offset().left + l.outerWidth() + 1 : o.left = l.offset().left - 1, this.segPopover = new u.default(o), this.segPopover.show(), this.bindAllSegHandlersToEl(this.segPopover.el), this.triggerAfterEventSegsRendered(i)
                }, t.prototype.renderSegPopoverContent = function(t, e, n) {
                    var i, r = this.view.calendar.theme,
                        o = this.getCellDate(t, e).format(this.opt("dayPopoverFormat")),
                        s = E('<div class="fc-header ' + r.getClass("popoverHeader") + '"><span class="fc-close ' + r.getIconClass("close") + '"></span><span class="fc-title">' + l.htmlEscape(o) + '</span><div class="fc-clear"/></div><div class="fc-body ' + r.getClass("popoverContent") + '"><div class="fc-event-container"></div></div>'),
                        a = s.find(".fc-event-container");
                    for (n = this.eventRenderer.renderFgSegEls(n, !0), this.popoverSegs = n, i = 0; i < n.length; i++) this.hitsNeeded(), n[i].hit = this.getCellHit(t, e), this.hitsNotNeeded(), a.append(n[i].el);
                    return s
                }, t.prototype.resliceDaySegs = function(t, e) {
                    var n, i, r, o = e.clone(),
                        s = o.clone().add(1, "days"),
                        a = new d.default(o, s),
                        l = [];
                    for (n = 0; n < t.length; n++)(r = (i = t[n]).footprint.componentFootprint.unzonedRange.intersect(a)) && l.push(E.extend({}, i, {
                        footprint: new p.default(new c.default(r, i.footprint.componentFootprint.isAllDay), i.footprint.eventDef, i.footprint.eventInstance),
                        isStart: i.isStart && r.isStart,
                        isEnd: i.isEnd && r.isEnd
                    }));
                    return this.eventRenderer.sortEventSegs(l), l
                }, t.prototype.getMoreLinkText = function(t) {
                    var e = this.opt("eventLimitText");
                    return "function" == typeof e ? e(t) : "+" + t + " " + e
                }, t.prototype.getCellSegs = function(t, e, n) {
                    for (var i, r = this.eventRenderer.rowStructs[t].segMatrix, o = n || 0, s = []; o < r.length;)(i = r[o][e]) && s.push(i), o++;
                    return s
                }, t
            }(a.default);
        (e.default = y).prototype.eventRendererClass = f.default, y.prototype.businessHourRendererClass = r.default, y.prototype.helperRendererClass = g.default, y.prototype.fillRendererClass = v.default, o.default.mixInto(y), h.default.mixInto(y)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(3),
            l = n(4),
            o = n(39),
            s = n(41),
            a = n(228),
            u = n(61),
            d = function(a) {
                function t(t, e) {
                    var n = a.call(this, t, e) || this;
                    return n.dayGrid = n.instantiateDayGrid(), n.dayGrid.isRigid = n.hasRigidRows(), n.opt("weekNumbers") && (n.opt("weekNumbersWithinDays") ? (n.dayGrid.cellWeekNumbersVisible = !0, n.dayGrid.colWeekNumbersVisible = !1) : (n.dayGrid.cellWeekNumbersVisible = !1, n.dayGrid.colWeekNumbersVisible = !0)), n.addChild(n.dayGrid), n.scroller = new o.default({
                        overflowX: "hidden",
                        overflowY: "auto"
                    }), n
                }
                return i.__extends(t, a), t.prototype.instantiateDayGrid = function() {
                    return new(function(e) {
                        function t() {
                            var t = null !== e && e.apply(this, arguments) || this;
                            return t.colWeekNumbersVisible = !1, t
                        }
                        return i.__extends(t, e), t.prototype.renderHeadIntroHtml = function() {
                            var t = this.view;
                            return this.colWeekNumbersVisible ? '<th class="fc-week-number ' + t.calendar.theme.getClass("widgetHeader") + '" ' + t.weekNumberStyleAttr() + "><span>" + l.htmlEscape(this.opt("weekNumberTitle")) + "</span></th>" : ""
                        }, t.prototype.renderNumberIntroHtml = function(t) {
                            var e = this.view,
                                n = this.getCellDate(t, 0);
                            return this.colWeekNumbersVisible ? '<td class="fc-week-number" ' + e.weekNumberStyleAttr() + ">" + e.buildGotoAnchorHtml({
                                date: n,
                                type: "week",
                                forceOff: 1 === this.colCnt
                            }, n.format("w")) + "</td>" : ""
                        }, t.prototype.renderBgIntroHtml = function() {
                            var t = this.view;
                            return this.colWeekNumbersVisible ? '<td class="fc-week-number ' + t.calendar.theme.getClass("widgetContent") + '" ' + t.weekNumberStyleAttr() + "></td>" : ""
                        }, t.prototype.renderIntroHtml = function() {
                            var t = this.view;
                            return this.colWeekNumbersVisible ? '<td class="fc-week-number" ' + t.weekNumberStyleAttr() + "></td>" : ""
                        }, t.prototype.getIsNumbersVisible = function() {
                            return u.default.prototype.getIsNumbersVisible.apply(this, arguments) || this.colWeekNumbersVisible
                        }, t
                    }(this.dayGridClass))(this)
                }, t.prototype.executeDateRender = function(t) {
                    this.dayGrid.breakOnWeeks = /year|month|week/.test(t.currentRangeUnit), a.prototype.executeDateRender.call(this, t)
                }, t.prototype.renderSkeleton = function() {
                    var t, e;
                    this.el.addClass("fc-basic-view").html(this.renderSkeletonHtml()), this.scroller.render(), t = this.scroller.el.addClass("fc-day-grid-container"), e = r('<div class="fc-day-grid" />').appendTo(t), this.el.find(".fc-body > tr > td").append(t), this.dayGrid.headContainerEl = this.el.find(".fc-head-container"), this.dayGrid.setElement(e)
                }, t.prototype.unrenderSkeleton = function() {
                    this.dayGrid.removeElement(), this.scroller.destroy()
                }, t.prototype.renderSkeletonHtml = function() {
                    var t = this.calendar.theme;
                    return '<table class="' + t.getClass("tableGrid") + '">' + (this.opt("columnHeader") ? '<thead class="fc-head"><tr><td class="fc-head-container ' + t.getClass("widgetHeader") + '">&nbsp;</td></tr></thead>' : "") + '<tbody class="fc-body"><tr><td class="' + t.getClass("widgetContent") + '"></td></tr></tbody></table>'
                }, t.prototype.weekNumberStyleAttr = function() {
                    return null != this.weekNumberWidth ? 'style="width:' + this.weekNumberWidth + 'px"' : ""
                }, t.prototype.hasRigidRows = function() {
                    var t = this.opt("eventLimit");
                    return t && "number" != typeof t
                }, t.prototype.updateSize = function(t, e, n) {
                    var i, r, o = this.opt("eventLimit"),
                        s = this.dayGrid.headContainerEl.find(".fc-row");
                    this.dayGrid.rowEls ? (a.prototype.updateSize.call(this, t, e, n), this.dayGrid.colWeekNumbersVisible && (this.weekNumberWidth = l.matchCellWidths(this.el.find(".fc-week-number"))), this.scroller.clear(), l.uncompensateScroll(s), this.dayGrid.removeSegPopover(), o && "number" == typeof o && this.dayGrid.limitRows(o), i = this.computeScrollerHeight(t), this.setGridHeight(i, e), o && "number" != typeof o && this.dayGrid.limitRows(o), e || (this.scroller.setHeight(i), ((r = this.scroller.getScrollbarWidths()).left || r.right) && (l.compensateScroll(s, r), i = this.computeScrollerHeight(t), this.scroller.setHeight(i)), this.scroller.lockOverflow(r))) : e || (i = this.computeScrollerHeight(t), this.scroller.setHeight(i))
                }, t.prototype.computeScrollerHeight = function(t) {
                    return t - l.subtractInnerElHeight(this.el, this.scroller.el)
                }, t.prototype.setGridHeight = function(t, e) {
                    e ? l.undistributeHeight(this.dayGrid.rowEls) : l.distributeHeight(this.dayGrid.rowEls, t, !0)
                }, t.prototype.computeInitialDateScroll = function() {
                    return {
                        top: 0
                    }
                }, t.prototype.queryDateScroll = function() {
                    return {
                        top: this.scroller.getScrollTop()
                    }
                }, t.prototype.applyDateScroll = function(t) {
                    void 0 !== t.top && this.scroller.setScrollTop(t.top)
                }, t
            }(s.default);
        (e.default = d).prototype.dateProfileGeneratorClass = a.default, d.prototype.dayGridClass = u.default
    }, , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(5),
            r = n(12),
            o = n(49),
            s = n(6),
            u = n(35),
            a = function() {
                function t(t, e) {
                    this.eventManager = t, this._calendar = e
                }
                return t.prototype.opt = function(t) {
                    return this._calendar.opt(t)
                }, t.prototype.isEventInstanceGroupAllowed = function(t) {
                    var e, n = t.getEventDef(),
                        i = this.eventRangesToEventFootprints(t.getAllEventRanges()),
                        r = this.getPeerEventInstances(n).map(u.eventInstanceToEventRange),
                        o = this.eventRangesToEventFootprints(r),
                        s = n.getConstraint(),
                        a = n.getOverlap(),
                        l = this.opt("eventAllow");
                    for (e = 0; e < i.length; e++)
                        if (!this.isFootprintAllowed(i[e].componentFootprint, o, s, a, i[e].eventInstance)) return !1;
                    if (l)
                        for (e = 0; e < i.length; e++)
                            if (!1 === l(i[e].componentFootprint.toLegacy(this._calendar), i[e].getEventLegacy())) return !1;
                    return !0
                }, t.prototype.getPeerEventInstances = function(t) {
                    return this.eventManager.getEventInstancesWithoutId(t.id)
                }, t.prototype.isSelectionFootprintAllowed = function(t) {
                    var e, n = this.eventManager.getEventInstances().map(u.eventInstanceToEventRange),
                        i = this.eventRangesToEventFootprints(n);
                    return !!this.isFootprintAllowed(t, i, this.opt("selectConstraint"), this.opt("selectOverlap")) && (!(e = this.opt("selectAllow")) || !1 !== e(t.toLegacy(this._calendar)))
                }, t.prototype.isFootprintAllowed = function(t, e, n, i, r) {
                    var o, s;
                    if (null != n && (o = this.constraintValToFootprints(n, t.isAllDay), !this.isFootprintWithinConstraints(t, o))) return !1;
                    if (s = this.collectOverlapEventFootprints(e, t), !1 === i) {
                        if (s.length) return !1
                    } else if ("function" == typeof i && ! function(t, e, n) {
                            var i;
                            for (i = 0; i < t.length; i++)
                                if (!e(t[i].eventInstance.toLegacy(), n ? n.toLegacy() : null)) return !1;
                            return !0
                        }(s, i, r)) return !1;
                    return !(r && ! function(t, e) {
                        var n, i, r, o, s = e.toLegacy();
                        for (n = 0; n < t.length; n++) {
                            if (i = t[n].eventInstance, r = i.def, !1 === (o = r.getOverlap())) return !1;
                            if ("function" == typeof o && !o(i.toLegacy(), s)) return !1
                        }
                        return !0
                    }(s, r))
                }, t.prototype.isFootprintWithinConstraints = function(t, e) {
                    var n;
                    for (n = 0; n < e.length; n++)
                        if (this.footprintContainsFootprint(e[n], t)) return !0;
                    return !1
                }, t.prototype.constraintValToFootprints = function(t, e) {
                    var n;
                    return "businessHours" === t ? this.buildCurrentBusinessFootprints(e) : "object" == typeof t ? (n = this.parseEventDefToInstances(t)) ? this.eventInstancesToFootprints(n) : this.parseFootprints(t) : null != t ? (n = this.eventManager.getEventInstancesWithId(t), this.eventInstancesToFootprints(n)) : void 0
                }, t.prototype.buildCurrentBusinessFootprints = function(t) {
                    var e = this._calendar.view,
                        n = e.get("businessHourGenerator"),
                        i = e.dateProfile.activeUnzonedRange,
                        r = n.buildEventInstanceGroup(t, i);
                    return r ? this.eventInstancesToFootprints(r.eventInstances) : []
                }, t.prototype.eventInstancesToFootprints = function(t) {
                    var e = t.map(u.eventInstanceToEventRange);
                    return this.eventRangesToEventFootprints(e).map(u.eventFootprintToComponentFootprint)
                }, t.prototype.collectOverlapEventFootprints = function(t, e) {
                    var n, i = [];
                    for (n = 0; n < t.length; n++) this.footprintsIntersect(e, t[n].componentFootprint) && i.push(t[n]);
                    return i
                }, t.prototype.parseEventDefToInstances = function(t) {
                    var e = this.eventManager,
                        n = o.default.parse(t, new s.default(this._calendar));
                    return !!n && n.buildInstances(e.currentPeriod.unzonedRange)
                }, t.prototype.eventRangesToEventFootprints = function(t) {
                    var e, n = [];
                    for (e = 0; e < t.length; e++) n.push.apply(n, this.eventRangeToEventFootprints(t[e]));
                    return n
                }, t.prototype.eventRangeToEventFootprints = function(t) {
                    return [u.eventRangeToEventFootprint(t)]
                }, t.prototype.parseFootprints = function(t) {
                    var e, n;
                    return t.start && ((e = this._calendar.moment(t.start)).isValid() || (e = null)), t.end && ((n = this._calendar.moment(t.end)).isValid() || (n = null)), [new r.default(new i.default(e, n), e && !e.hasTime() || n && !n.hasTime())]
                }, t.prototype.footprintContainsFootprint = function(t, e) {
                    return t.unzonedRange.containsRange(e.unzonedRange)
                }, t.prototype.footprintsIntersect = function(t, e) {
                    return t.unzonedRange.intersectsWith(e.unzonedRange)
                }, t
            }();
        e.default = a
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(4),
            o = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.defineStandardProps = function(t) {
                    var e = this.prototype;
                    e.hasOwnProperty("standardPropMap") || (e.standardPropMap = Object.create(e.standardPropMap)), r.copyOwnProps(t, e.standardPropMap)
                }, e.copyVerbatimStandardProps = function(t, e) {
                    var n, i = this.prototype.standardPropMap;
                    for (n in i) null != t[n] && !0 === i[n] && (e[n] = t[n])
                }, e.prototype.applyProps = function(t) {
                    var e, n = this.standardPropMap,
                        i = {},
                        r = {};
                    for (e in t) !0 === n[e] ? this[e] = t[e] : !1 === n[e] ? i[e] = t[e] : r[e] = t[e];
                    return this.applyMiscProps(r), this.applyManualStandardProps(i)
                }, e.prototype.applyManualStandardProps = function(t) {
                    return !0
                }, e.prototype.applyMiscProps = function(t) {}, e.prototype.isStandardProp = function(t) {
                    return t in this.standardPropMap
                }, e
            }(n(14).default);
        (e.default = o).prototype.standardPropMap = {}
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function() {
            function t(t, e) {
                this.def = t, this.dateProfile = e
            }
            return t.prototype.toLegacy = function() {
                var t = this.dateProfile,
                    e = this.def.toLegacy();
                return e.start = t.start.clone(), e.end = t.end ? t.end.clone() : null, e
            }, t
        }();
        e.default = n
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(3),
            o = n(0),
            s = n(34),
            l = n(209),
            u = n(17),
            a = function(e) {
                function t() {
                    return null !== e && e.apply(this, arguments) || this
                }
                return i.__extends(t, e), t.prototype.isAllDay = function() {
                    return !this.startTime && !this.endTime
                }, t.prototype.buildInstances = function(t) {
                    for (var e, n, i, r = this.source.calendar, o = t.getStart(), s = t.getEnd(), a = []; o.isBefore(s);) this.dowHash && !this.dowHash[o.day()] || (n = (e = r.applyTimezone(o)).clone(), i = null, this.startTime ? n.time(this.startTime) : n.stripTime(), this.endTime && (i = e.clone().time(this.endTime)), a.push(new l.default(this, new u.default(n, i, r)))), o.add(1, "days");
                    return a
                }, t.prototype.setDow = function(t) {
                    this.dowHash || (this.dowHash = {});
                    for (var e = 0; e < t.length; e++) this.dowHash[t[e]] = !0
                }, t.prototype.clone = function() {
                    var t = e.prototype.clone.call(this);
                    return t.startTime && (t.startTime = o.duration(this.startTime)), t.endTime && (t.endTime = o.duration(this.endTime)), this.dowHash && (t.dowHash = r.extend({}, this.dowHash)), t
                }, t
            }(s.default);
        (e.default = a).prototype.applyProps = function(t) {
            var e = s.default.prototype.applyProps.call(this, t);
            return t.start && (this.startTime = o.duration(t.start)), t.end && (this.endTime = o.duration(t.end)), t.dow && this.setDow(t.dow), e
        }, a.defineStandardProps({
            start: !1,
            end: !1,
            dow: !1
        })
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function(t, e, n) {
            this.unzonedRange = t, this.eventDef = e, n && (this.eventInstance = n)
        };
        e.default = n
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var s = n(3),
            r = n(35),
            o = n(18),
            i = n(210),
            a = n(6),
            l = {
                start: "09:00",
                end: "17:00",
                dow: [1, 2, 3, 4, 5],
                rendering: "inverse-background"
            },
            u = function() {
                function t(t, e) {
                    this.rawComplexDef = t, this.calendar = e
                }
                return t.prototype.buildEventInstanceGroup = function(t, e) {
                    var n, i = this.buildEventDefs(t);
                    if (i.length) return (n = new o.default(r.eventDefsToEventInstances(i, e))).explicitEventDef = i[0], n
                }, t.prototype.buildEventDefs = function(t) {
                    var e, n = this.rawComplexDef,
                        i = [],
                        r = !1,
                        o = [];
                    for (!0 === n ? i = [{}] : s.isPlainObject(n) ? i = [n] : s.isArray(n) && (i = n, r = !0), e = 0; e < i.length; e++) r && !i[e].dow || o.push(this.buildEventDef(t, i[e]));
                    return o
                }, t.prototype.buildEventDef = function(t, e) {
                    var n = s.extend({}, l, e);
                    return t && (n.start = null, n.end = null), i.default.parse(n, new a.default(this.calendar))
                }, t
            }();
        e.default = u
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e
            }(n(19).default);
        (e.default = r).prototype.classes = {
            widget: "fc-unthemed",
            widgetHeader: "fc-widget-header",
            widgetContent: "fc-widget-content",
            buttonGroup: "fc-button-group",
            button: "fc-button",
            cornerLeft: "fc-corner-left",
            cornerRight: "fc-corner-right",
            stateDefault: "fc-state-default",
            stateActive: "fc-state-active",
            stateDisabled: "fc-state-disabled",
            stateHover: "fc-state-hover",
            stateDown: "fc-state-down",
            popoverHeader: "fc-widget-header",
            popoverContent: "fc-widget-content",
            headerRow: "fc-widget-header",
            dayRow: "fc-widget-content",
            listView: "fc-widget-content"
        }, r.prototype.baseIconClass = "fc-icon", r.prototype.iconClasses = {
            close: "fc-icon-x",
            prev: "fc-icon-left-single-arrow",
            next: "fc-icon-right-single-arrow",
            prevYear: "fc-icon-left-double-arrow",
            nextYear: "fc-icon-right-double-arrow"
        }, r.prototype.iconOverrideOption = "buttonIcons", r.prototype.iconOverrideCustomButtonOption = "icon", r.prototype.iconOverridePrefix = "fc-icon-"
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e
            }(n(19).default);
        (e.default = r).prototype.classes = {
            widget: "ui-widget",
            widgetHeader: "ui-widget-header",
            widgetContent: "ui-widget-content",
            buttonGroup: "fc-button-group",
            button: "ui-button",
            cornerLeft: "ui-corner-left",
            cornerRight: "ui-corner-right",
            stateDefault: "ui-state-default",
            stateActive: "ui-state-active",
            stateDisabled: "ui-state-disabled",
            stateHover: "ui-state-hover",
            stateDown: "ui-state-down",
            today: "ui-state-highlight",
            popoverHeader: "ui-widget-header",
            popoverContent: "ui-widget-content",
            headerRow: "ui-widget-header",
            dayRow: "ui-widget-content",
            listView: "ui-widget-content"
        }, r.prototype.baseIconClass = "ui-icon", r.prototype.iconClasses = {
            close: "ui-icon-closethick",
            prev: "ui-icon-circle-triangle-w",
            next: "ui-icon-circle-triangle-e",
            prevYear: "ui-icon-seek-prev",
            nextYear: "ui-icon-seek-next"
        }, r.prototype.iconOverrideOption = "themeButtonIcons", r.prototype.iconOverrideCustomButtonOption = "themeIcon", r.prototype.iconOverridePrefix = "ui-icon-"
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(3),
            o = n(20),
            s = n(6),
            a = function(n) {
                function t() {
                    return null !== n && n.apply(this, arguments) || this
                }
                return i.__extends(t, n), t.parse = function(t, e) {
                    var n;
                    return r.isFunction(t.events) ? n = t : r.isFunction(t) && (n = {
                        events: t
                    }), !!n && s.default.parse.call(this, n, e)
                }, t.prototype.fetch = function(t, n, i) {
                    var r = this;
                    return this.calendar.pushLoading(), o.default.construct(function(e) {
                        r.func.call(r.calendar, t.clone(), n.clone(), i, function(t) {
                            r.calendar.popLoading(), e(r.parseEventDefs(t))
                        })
                    })
                }, t.prototype.getPrimitive = function() {
                    return this.func
                }, t.prototype.applyManualStandardProps = function(t) {
                    var e = n.prototype.applyManualStandardProps.call(this, t);
                    return this.func = t.events, e
                }, t
            }(s.default);
        (e.default = a).defineStandardProps({
            events: !1
        })
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            c = n(3),
            p = n(4),
            r = n(20),
            o = n(6),
            s = function(t) {
                function d() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(d, t), d.parse = function(t, e) {
                    var n;
                    return "string" == typeof t.url ? n = t : "string" == typeof t && (n = {
                        url: t
                    }), !!n && o.default.parse.call(this, n, e)
                }, d.prototype.fetch = function(t, e, n) {
                    var s = this,
                        i = this.ajaxSettings,
                        a = i.success,
                        l = i.error,
                        u = this.buildRequestParams(t, e, n);
                    return this.calendar.pushLoading(), r.default.construct(function(r, o) {
                        c.ajax(c.extend({}, d.AJAX_DEFAULTS, i, {
                            url: s.url,
                            data: u,
                            success: function(t, e, n) {
                                var i;
                                s.calendar.popLoading(), t ? (i = p.applyAll(a, s, [t, e, n]), c.isArray(i) && (t = i), r(s.parseEventDefs(t))) : o()
                            },
                            error: function(t, e, n) {
                                s.calendar.popLoading(), p.applyAll(l, s, [t, e, n]), o()
                            }
                        }))
                    })
                }, d.prototype.buildRequestParams = function(t, e, n) {
                    var i, r, o, s, a = this.calendar,
                        l = this.ajaxSettings,
                        u = {};
                    return null == (i = this.startParam) && (i = a.opt("startParam")), null == (r = this.endParam) && (r = a.opt("endParam")), null == (o = this.timezoneParam) && (o = a.opt("timezoneParam")), s = c.isFunction(l.data) ? l.data() : l.data || {}, c.extend(u, s), u[i] = t.format(), u[r] = e.format(), n && "local" !== n && (u[o] = n), u
                }, d.prototype.getPrimitive = function() {
                    return this.url
                }, d.prototype.applyMiscProps = function(t) {
                    this.ajaxSettings = t
                }, d.AJAX_DEFAULTS = {
                    dataType: "json",
                    cache: !1
                }, d
            }(o.default);
        (e.default = s).defineStandardProps({
            url: !0,
            startParam: !0,
            endParam: !0,
            timezoneParam: !0
        })
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(11),
            r = function() {
                function t() {
                    this.q = [], this.isPaused = !1, this.isRunning = !1
                }
                return t.prototype.queue = function() {
                    for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e];
                    this.q.push.apply(this.q, t), this.tryStart()
                }, t.prototype.pause = function() {
                    this.isPaused = !0
                }, t.prototype.resume = function() {
                    this.isPaused = !1, this.tryStart()
                }, t.prototype.getIsIdle = function() {
                    return !this.isRunning && !this.isPaused
                }, t.prototype.tryStart = function() {
                    !this.isRunning && this.canRunNext() && (this.isRunning = !0, this.trigger("start"), this.runRemaining())
                }, t.prototype.canRunNext = function() {
                    return !this.isPaused && this.q.length
                }, t.prototype.runRemaining = function() {
                    var t, e, n = this;
                    do {
                        if (t = this.q.shift(), (e = this.runTask(t)) && e.then) return void e.then(function() {
                            n.canRunNext() && n.runRemaining()
                        })
                    } while (this.canRunNext());
                    this.trigger("stop"), this.isRunning = !1, this.tryStart()
                }, t.prototype.runTask = function(t) {
                    return t()
                }, t
            }();
        e.default = r, i.default.mixInto(r)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = function(n) {
                function t(t) {
                    var e = n.call(this) || this;
                    return e.waitsByNamespace = t || {}, e
                }
                return i.__extends(t, n), t.prototype.queue = function(t, e, n) {
                    var i, r = {
                        func: t,
                        namespace: e,
                        type: n
                    };
                    e && (i = this.waitsByNamespace[e]), this.waitNamespace && (e === this.waitNamespace && null != i ? this.delayWait(i) : (this.clearWait(), this.tryStart())), this.compoundTask(r) && (this.waitNamespace || null == i ? this.tryStart() : this.startWait(e, i))
                }, t.prototype.startWait = function(t, e) {
                    this.waitNamespace = t, this.spawnWait(e)
                }, t.prototype.delayWait = function(t) {
                    clearTimeout(this.waitId), this.spawnWait(t)
                }, t.prototype.spawnWait = function(t) {
                    var e = this;
                    this.waitId = setTimeout(function() {
                        e.waitNamespace = null, e.tryStart()
                    }, t)
                }, t.prototype.clearWait = function() {
                    this.waitNamespace && (clearTimeout(this.waitId), this.waitId = null, this.waitNamespace = null)
                }, t.prototype.canRunNext = function() {
                    if (!n.prototype.canRunNext.call(this)) return !1;
                    if (this.waitNamespace) {
                        for (var t = this.q, e = 0; e < t.length; e++)
                            if (t[e].namespace !== this.waitNamespace) return !0;
                        return !1
                    }
                    return !0
                }, t.prototype.runTask = function(t) {
                    t.func()
                }, t.prototype.compoundTask = function(t) {
                    var e, n = this.q,
                        i = !0;
                    if (t.namespace && "destroy" === t.type)
                        for (e = n.length - 1; 0 <= e; e--) switch (n[e].type) {
                            case "init":
                                i = !1;
                            case "add":
                            case "remove":
                                n.splice(e, 1)
                        }
                    return i && n.push(t), i
                }, t
            }(n(217).default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var o = n(2),
            a = n(3),
            s = n(0),
            l = n(4),
            u = n(10),
            d = n(47),
            i = n(237),
            c = n(35),
            r = function(i) {
                function r(t, e) {
                    var n = i.call(this) || this;
                    return n.isRTL = !1, n.hitsNeededDepth = 0, n.hasAllDayBusinessHours = !1, n.isDatesRendered = !1, t && (n.view = t), e && (n.options = e), n.uid = String(r.guid++), n.childrenByUid = {}, n.nextDayThreshold = s.duration(n.opt("nextDayThreshold")), n.isRTL = n.opt("isRTL"), n.fillRendererClass && (n.fillRenderer = new n.fillRendererClass(n)), n.eventRendererClass && (n.eventRenderer = new n.eventRendererClass(n, n.fillRenderer)), n.helperRendererClass && n.eventRenderer && (n.helperRenderer = new n.helperRendererClass(n, n.eventRenderer)), n.businessHourRendererClass && n.fillRenderer && (n.businessHourRenderer = new n.businessHourRendererClass(n, n.fillRenderer)), n
                }
                return o.__extends(r, i), r.prototype.addChild = function(t) {
                    return !this.childrenByUid[t.uid] && (this.childrenByUid[t.uid] = t, !0)
                }, r.prototype.removeChild = function(t) {
                    return !!this.childrenByUid[t.uid] && (delete this.childrenByUid[t.uid], !0)
                }, r.prototype.updateSize = function(t, e, n) {
                    this.callChildren("updateSize", arguments)
                }, r.prototype.opt = function(t) {
                    return this._getView().opt(t)
                }, r.prototype.publiclyTrigger = function() {
                    for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e];
                    var n = this._getCalendar();
                    return n.publiclyTrigger.apply(n, t)
                }, r.prototype.hasPublicHandlers = function() {
                    for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e];
                    var n = this._getCalendar();
                    return n.hasPublicHandlers.apply(n, t)
                }, r.prototype.executeDateRender = function(t) {
                    this.dateProfile = t, this.renderDates(t), this.isDatesRendered = !0, this.callChildren("executeDateRender", arguments)
                }, r.prototype.executeDateUnrender = function() {
                    this.callChildren("executeDateUnrender", arguments), this.dateProfile = null, this.unrenderDates(), this.isDatesRendered = !1
                }, r.prototype.renderDates = function(t) {}, r.prototype.unrenderDates = function() {}, r.prototype.getNowIndicatorUnit = function() {}, r.prototype.renderNowIndicator = function(t) {
                    this.callChildren("renderNowIndicator", arguments)
                }, r.prototype.unrenderNowIndicator = function() {
                    this.callChildren("unrenderNowIndicator", arguments)
                }, r.prototype.renderBusinessHours = function(t) {
                    this.businessHourRenderer && this.businessHourRenderer.render(t), this.callChildren("renderBusinessHours", arguments)
                }, r.prototype.unrenderBusinessHours = function() {
                    this.callChildren("unrenderBusinessHours", arguments), this.businessHourRenderer && this.businessHourRenderer.unrender()
                }, r.prototype.executeEventRender = function(t) {
                    this.eventRenderer ? (this.eventRenderer.rangeUpdated(), this.eventRenderer.render(t)) : this.renderEvents && this.renderEvents(function(t) {
                        var e, n, i, r = [];
                        for (e in t)
                            for (n = t[e].eventInstances, i = 0; i < n.length; i++) r.push(n[i].toLegacy());
                        return r
                    }(t)), this.callChildren("executeEventRender", arguments)
                }, r.prototype.executeEventUnrender = function() {
                    this.callChildren("executeEventUnrender", arguments), this.eventRenderer ? this.eventRenderer.unrender() : this.destroyEvents && this.destroyEvents()
                }, r.prototype.getBusinessHourSegs = function() {
                    var e = this.getOwnBusinessHourSegs();
                    return this.iterChildren(function(t) {
                        e.push.apply(e, t.getBusinessHourSegs())
                    }), e
                }, r.prototype.getOwnBusinessHourSegs = function() {
                    return this.businessHourRenderer ? this.businessHourRenderer.getSegs() : []
                }, r.prototype.getEventSegs = function() {
                    var e = this.getOwnEventSegs();
                    return this.iterChildren(function(t) {
                        e.push.apply(e, t.getEventSegs())
                    }), e
                }, r.prototype.getOwnEventSegs = function() {
                    return this.eventRenderer ? this.eventRenderer.getSegs() : []
                }, r.prototype.triggerAfterEventsRendered = function() {
                    this.triggerAfterEventSegsRendered(this.getEventSegs()), this.publiclyTrigger("eventAfterAllRender", {
                        context: this,
                        args: [this]
                    })
                }, r.prototype.triggerAfterEventSegsRendered = function(t) {
                    var n = this;
                    this.hasPublicHandlers("eventAfterRender") && t.forEach(function(t) {
                        var e;
                        t.el && (e = t.footprint.getEventLegacy(), n.publiclyTrigger("eventAfterRender", {
                            context: e,
                            args: [e, t.el, n]
                        }))
                    })
                }, r.prototype.triggerBeforeEventsDestroyed = function() {
                    this.triggerBeforeEventSegsDestroyed(this.getEventSegs())
                }, r.prototype.triggerBeforeEventSegsDestroyed = function(t) {
                    var n = this;
                    this.hasPublicHandlers("eventDestroy") && t.forEach(function(t) {
                        var e;
                        t.el && (e = t.footprint.getEventLegacy(), n.publiclyTrigger("eventDestroy", {
                            context: e,
                            args: [e, t.el, n]
                        }))
                    })
                }, r.prototype.showEventsWithId = function(e) {
                    this.getEventSegs().forEach(function(t) {
                        t.footprint.eventDef.id === e && t.el && t.el.css("visibility", "")
                    }), this.callChildren("showEventsWithId", arguments)
                }, r.prototype.hideEventsWithId = function(e) {
                    this.getEventSegs().forEach(function(t) {
                        t.footprint.eventDef.id === e && t.el && t.el.css("visibility", "hidden")
                    }), this.callChildren("hideEventsWithId", arguments)
                }, r.prototype.renderDrag = function(e, n, i) {
                    var r = !1;
                    return this.iterChildren(function(t) {
                        t.renderDrag(e, n, i) && (r = !0)
                    }), r
                }, r.prototype.unrenderDrag = function() {
                    this.callChildren("unrenderDrag", arguments)
                }, r.prototype.renderEventResize = function(t, e, n) {
                    this.callChildren("renderEventResize", arguments)
                }, r.prototype.unrenderEventResize = function() {
                    this.callChildren("unrenderEventResize", arguments)
                }, r.prototype.renderSelectionFootprint = function(t) {
                    this.renderHighlight(t), this.callChildren("renderSelectionFootprint", arguments)
                }, r.prototype.unrenderSelection = function() {
                    this.unrenderHighlight(), this.callChildren("unrenderSelection", arguments)
                }, r.prototype.renderHighlight = function(t) {
                    this.fillRenderer && this.fillRenderer.renderFootprint("highlight", t, {
                        getClasses: function() {
                            return ["fc-highlight"]
                        }
                    }), this.callChildren("renderHighlight", arguments)
                }, r.prototype.unrenderHighlight = function() {
                    this.fillRenderer && this.fillRenderer.unrender("highlight"), this.callChildren("unrenderHighlight", arguments)
                }, r.prototype.hitsNeeded = function() {
                    this.hitsNeededDepth++ || this.prepareHits(), this.callChildren("hitsNeeded", arguments)
                }, r.prototype.hitsNotNeeded = function() {
                    this.hitsNeededDepth && !--this.hitsNeededDepth && this.releaseHits(), this.callChildren("hitsNotNeeded", arguments)
                }, r.prototype.prepareHits = function() {}, r.prototype.releaseHits = function() {}, r.prototype.queryHit = function(t, e) {
                    var n, i, r = this.childrenByUid;
                    for (n in r)
                        if (i = r[n].queryHit(t, e)) break;
                    return i
                }, r.prototype.getSafeHitFootprint = function(t) {
                    var e = this.getHitFootprint(t);
                    return this.dateProfile.activeUnzonedRange.containsRange(e.unzonedRange) ? e : null
                }, r.prototype.getHitFootprint = function(t) {}, r.prototype.getHitEl = function(t) {}, r.prototype.eventRangesToEventFootprints = function(t) {
                    var e, n = [];
                    for (e = 0; e < t.length; e++) n.push.apply(n, this.eventRangeToEventFootprints(t[e]));
                    return n
                }, r.prototype.eventRangeToEventFootprints = function(t) {
                    return [c.eventRangeToEventFootprint(t)]
                }, r.prototype.eventFootprintsToSegs = function(t) {
                    var e, n = [];
                    for (e = 0; e < t.length; e++) n.push.apply(n, this.eventFootprintToSegs(t[e]));
                    return n
                }, r.prototype.eventFootprintToSegs = function(t) {
                    var e, n, i, r = t.componentFootprint.unzonedRange;
                    for (e = this.componentFootprintToSegs(t.componentFootprint), n = 0; n < e.length; n++) i = e[n], r.isStart || (i.isStart = !1), r.isEnd || (i.isEnd = !1), i.footprint = t;
                    return e
                }, r.prototype.componentFootprintToSegs = function(t) {
                    return []
                }, r.prototype.callChildren = function(e, n) {
                    this.iterChildren(function(t) {
                        t[e].apply(t, n)
                    })
                }, r.prototype.iterChildren = function(t) {
                    var e, n = this.childrenByUid;
                    for (e in n) t(n[e])
                }, r.prototype._getCalendar = function() {
                    return this.calendar || this.view.calendar
                }, r.prototype._getView = function() {
                    return this.view
                }, r.prototype._getDateProfile = function() {
                    return this._getView().get("dateProfile")
                }, r.prototype.buildGotoAnchorHtml = function(t, e, n) {
                    var i, r, o, s;
                    return a.isPlainObject(t) ? (i = t.date, r = t.type, o = t.forceOff) : i = t, s = {
                        date: (i = u.default(i)).format("YYYY-MM-DD"),
                        type: r || "day"
                    }, "string" == typeof e && (n = e, e = null), e = e ? " " + l.attrsToStr(e) : "", n = n || "", !o && this.opt("navLinks") ? "<a" + e + ' data-goto="' + l.htmlEscape(JSON.stringify(s)) + '">' + n + "</a>" : "<span" + e + ">" + n + "</span>"
                }, r.prototype.getAllDayHtml = function() {
                    return this.opt("allDayHtml") || l.htmlEscape(this.opt("allDayText"))
                }, r.prototype.getDayClasses = function(t, e) {
                    var n, i = this._getView(),
                        r = [];
                    return this.dateProfile.activeUnzonedRange.containsDate(t) ? (r.push("fc-" + l.dayIDs[t.day()]), i.isDateInOtherMonth(t, this.dateProfile) && r.push("fc-other-month"), n = i.calendar.getNow(), t.isSame(n, "day") ? (r.push("fc-today"), !0 !== e && r.push(i.calendar.theme.getClass("today"))) : t < n ? r.push("fc-past") : r.push("fc-future")) : r.push("fc-disabled-day"), r
                }, r.prototype.formatRange = function(t, e, n, i) {
                    var r = t.end;
                    return e && (r = r.clone().subtract(1)), d.formatRange(t.start, r, n, i, this.isRTL)
                }, r.prototype.currentRangeAs = function(t) {
                    return this._getDateProfile().currentUnzonedRange.as(t)
                }, r.prototype.computeDayRange = function(t) {
                    var e = this._getCalendar(),
                        n = e.msToUtcMoment(t.startMs, !0),
                        i = e.msToUtcMoment(t.endMs),
                        r = +i.time(),
                        o = i.clone().stripTime();
                    return r && r >= this.nextDayThreshold && o.add(1, "days"), o <= n && (o = n.clone().add(1, "days")), {
                        start: n,
                        end: o
                    }
                }, r.prototype.isMultiDayRange = function(t) {
                    var e = this.computeDayRange(t);
                    return 1 < e.end.diff(e.start, "days")
                }, r.guid = 0, r
            }(i.default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var s = n(3),
            i = n(0),
            a = n(4),
            r = n(32),
            o = n(238),
            l = n(21),
            u = n(11),
            d = n(7),
            c = n(239),
            p = n(240),
            h = n(241),
            f = n(207),
            g = n(31),
            v = n(10),
            y = n(5),
            m = n(12),
            b = n(17),
            w = n(242),
            D = n(212),
            E = n(38),
            S = n(49),
            C = n(13),
            R = n(37),
            T = n(6),
            M = n(51),
            I = function() {
                function t(t, e) {
                    this.loadingLevel = 0, this.ignoreUpdateViewSize = 0, this.freezeContentHeightDepth = 0, l.default.needed(), this.el = t, this.viewsByType = {}, this.optionsManager = new p.default(this, e), this.viewSpecManager = new h.default(this.optionsManager, this), this.initMomentInternals(), this.initCurrentDate(), this.initEventManager(), this.constraints = new f.default(this.eventManager, this), this.constructed()
                }
                return t.prototype.constructed = function() {}, t.prototype.getView = function() {
                    return this.view
                }, t.prototype.publiclyTrigger = function(t, e) {
                    var n, i, r = this.opt(t);
                    if (s.isPlainObject(e) ? (n = e.context, i = e.args) : s.isArray(e) && (i = e), null == n && (n = this.el[0]), i || (i = []), this.triggerWith(t, n, i), r) return r.apply(n, i)
                }, t.prototype.hasPublicHandlers = function(t) {
                    return this.hasHandlers(t) || this.opt(t)
                }, t.prototype.option = function(t, e) {
                    var n;
                    if ("string" == typeof t) {
                        if (void 0 === e) return this.optionsManager.get(t);
                        (n = {})[t] = e, this.optionsManager.add(n)
                    } else "object" == typeof t && this.optionsManager.add(t)
                }, t.prototype.opt = function(t) {
                    return this.optionsManager.get(t)
                }, t.prototype.instantiateView = function(t) {
                    var e = this.viewSpecManager.getViewSpec(t);
                    if (!e) throw new Error('View type "' + t + '" is not valid');
                    return new e.class(this, e)
                }, t.prototype.isValidViewType = function(t) {
                    return Boolean(this.viewSpecManager.getViewSpec(t))
                }, t.prototype.changeView = function(t, e) {
                    e && (e.start && e.end ? this.optionsManager.recordOverrides({
                        visibleRange: e
                    }) : this.currentDate = this.moment(e).stripZone()), this.renderView(t)
                }, t.prototype.zoomTo = function(t, e) {
                    var n;
                    e = e || "day", n = this.viewSpecManager.getViewSpec(e) || this.viewSpecManager.getUnitViewSpec(e), this.currentDate = t.clone(), this.renderView(n ? n.type : null)
                }, t.prototype.initCurrentDate = function() {
                    var t = this.opt("defaultDate");
                    this.currentDate = null != t ? this.moment(t).stripZone() : this.getNow()
                }, t.prototype.prev = function() {
                    var t = this.view,
                        e = t.dateProfileGenerator.buildPrev(t.get("dateProfile"));
                    e.isValid && (this.currentDate = e.date, this.renderView())
                }, t.prototype.next = function() {
                    var t = this.view,
                        e = t.dateProfileGenerator.buildNext(t.get("dateProfile"));
                    e.isValid && (this.currentDate = e.date, this.renderView())
                }, t.prototype.prevYear = function() {
                    this.currentDate.add(-1, "years"), this.renderView()
                }, t.prototype.nextYear = function() {
                    this.currentDate.add(1, "years"), this.renderView()
                }, t.prototype.today = function() {
                    this.currentDate = this.getNow(), this.renderView()
                }, t.prototype.gotoDate = function(t) {
                    this.currentDate = this.moment(t).stripZone(), this.renderView()
                }, t.prototype.incrementDate = function(t) {
                    this.currentDate.add(i.duration(t)), this.renderView()
                }, t.prototype.getDate = function() {
                    return this.applyTimezone(this.currentDate)
                }, t.prototype.pushLoading = function() {
                    this.loadingLevel++ || this.publiclyTrigger("loading", [!0, this.view])
                }, t.prototype.popLoading = function() {
                    --this.loadingLevel || this.publiclyTrigger("loading", [!1, this.view])
                }, t.prototype.render = function() {
                    this.contentEl ? this.elementVisible() && (this.calcSize(), this.updateViewSize()) : this.initialRender()
                }, t.prototype.initialRender = function() {
                    var o = this,
                        i = this.el;
                    i.addClass("fc"), i.on("click.fc", "a[data-goto]", function(t) {
                        var e = s(t.currentTarget).data("goto"),
                            n = o.moment(e.date),
                            i = e.type,
                            r = o.view.opt("navLink" + a.capitaliseFirstLetter(i) + "Click");
                        "function" == typeof r ? r(n, t) : ("string" == typeof r && (i = r), o.zoomTo(n, i))
                    }), this.optionsManager.watch("settingTheme", ["?theme", "?themeSystem"], function(t) {
                        var e = new(M.getThemeSystemClass(t.themeSystem || t.theme))(o.optionsManager),
                            n = e.getClass("widget");
                        o.theme = e, n && i.addClass(n)
                    }, function() {
                        var t = o.theme.getClass("widget");
                        o.theme = null, t && i.removeClass(t)
                    }), this.optionsManager.watch("settingBusinessHourGenerator", ["?businessHours"], function(t) {
                        o.businessHourGenerator = new D.default(t.businessHours, o), o.view && o.view.set("businessHourGenerator", o.businessHourGenerator)
                    }, function() {
                        o.businessHourGenerator = null
                    }), this.optionsManager.watch("applyingDirClasses", ["?isRTL", "?locale"], function(t) {
                        i.toggleClass("fc-ltr", !t.isRTL), i.toggleClass("fc-rtl", t.isRTL)
                    }), this.contentEl = s("<div class='fc-view-container'/>").prependTo(i), this.initToolbars(), this.renderHeader(), this.renderFooter(), this.renderView(this.opt("defaultView")), this.opt("handleWindowResize") && s(window).resize(this.windowResizeProxy = a.debounce(this.windowResize.bind(this), this.opt("windowResizeDelay")))
                }, t.prototype.destroy = function() {
                    this.view && this.clearView(), this.toolbarsManager.proxyCall("removeElement"), this.contentEl.remove(), this.el.removeClass("fc fc-ltr fc-rtl"), this.optionsManager.unwatch("settingTheme"), this.optionsManager.unwatch("settingBusinessHourGenerator"), this.el.off(".fc"), this.windowResizeProxy && (s(window).unbind("resize", this.windowResizeProxy), this.windowResizeProxy = null), l.default.unneeded()
                }, t.prototype.elementVisible = function() {
                    return this.el.is(":visible")
                }, t.prototype.bindViewHandlers = function(e) {
                    var n = this;
                    e.watch("titleForCalendar", ["title"], function(t) {
                        e === n.view && n.setToolbarsTitle(t.title)
                    }), e.watch("dateProfileForCalendar", ["dateProfile"], function(t) {
                        e === n.view && (n.currentDate = t.dateProfile.date, n.updateToolbarButtons(t.dateProfile))
                    })
                }, t.prototype.unbindViewHandlers = function(t) {
                    t.unwatch("titleForCalendar"), t.unwatch("dateProfileForCalendar")
                }, t.prototype.renderView = function(t) {
                    var e, n = this.view;
                    this.freezeContentHeight(), n && t && n.type !== t && this.clearView(), !this.view && t && (e = this.view = this.viewsByType[t] || (this.viewsByType[t] = this.instantiateView(t)), this.bindViewHandlers(e), e.startBatchRender(), e.setElement(s("<div class='fc-view fc-" + t + "-view' />").appendTo(this.contentEl)), this.toolbarsManager.proxyCall("activateButton", t)), this.view && (this.view.get("businessHourGenerator") !== this.businessHourGenerator && this.view.set("businessHourGenerator", this.businessHourGenerator), this.view.setDate(this.currentDate), e && e.stopBatchRender()), this.thawContentHeight()
                }, t.prototype.clearView = function() {
                    var t = this.view;
                    this.toolbarsManager.proxyCall("deactivateButton", t.type), this.unbindViewHandlers(t), t.removeElement(), t.unsetDate(), this.view = null
                }, t.prototype.reinitView = function() {
                    var t = this.view,
                        e = t.queryScroll();
                    this.freezeContentHeight(), this.clearView(), this.calcSize(), this.renderView(t.type), this.view.applyScroll(e), this.thawContentHeight()
                }, t.prototype.getSuggestedViewHeight = function() {
                    return null == this.suggestedViewHeight && this.calcSize(), this.suggestedViewHeight
                }, t.prototype.isHeightAuto = function() {
                    return "auto" === this.opt("contentHeight") || "auto" === this.opt("height")
                }, t.prototype.updateViewSize = function(t) {
                    void 0 === t && (t = !1);
                    var e, n = this.view;
                    if (!this.ignoreUpdateViewSize && n) return t && (this.calcSize(), e = n.queryScroll()), this.ignoreUpdateViewSize++, n.updateSize(this.getSuggestedViewHeight(), this.isHeightAuto(), t), this.ignoreUpdateViewSize--, t && n.applyScroll(e), !0
                }, t.prototype.calcSize = function() {
                    this.elementVisible() && this._calcSize()
                }, t.prototype._calcSize = function() {
                    var t = this.opt("contentHeight"),
                        e = this.opt("height");
                    this.suggestedViewHeight = "number" == typeof t ? t : "function" == typeof t ? t() : "number" == typeof e ? e - this.queryToolbarsHeight() : "function" == typeof e ? e() - this.queryToolbarsHeight() : "parent" === e ? this.el.parent().height() - this.queryToolbarsHeight() : Math.round(this.contentEl.width() / Math.max(this.opt("aspectRatio"), .5))
                }, t.prototype.windowResize = function(t) {
                    t.target === window && this.view && this.view.isDatesRendered && this.updateViewSize(!0) && this.publiclyTrigger("windowResize", [this.view])
                }, t.prototype.freezeContentHeight = function() {
                    this.freezeContentHeightDepth++ || this.forceFreezeContentHeight()
                }, t.prototype.forceFreezeContentHeight = function() {
                    this.contentEl.css({
                        width: "100%",
                        height: this.contentEl.height(),
                        overflow: "hidden"
                    })
                }, t.prototype.thawContentHeight = function() {
                    this.freezeContentHeightDepth--, this.contentEl.css({
                        width: "",
                        height: "",
                        overflow: ""
                    }), this.freezeContentHeightDepth && this.forceFreezeContentHeight()
                }, t.prototype.initToolbars = function() {
                    this.header = new c.default(this, this.computeHeaderOptions()), this.footer = new c.default(this, this.computeFooterOptions()), this.toolbarsManager = new o.default([this.header, this.footer])
                }, t.prototype.computeHeaderOptions = function() {
                    return {
                        extraClasses: "fc-header-toolbar",
                        layout: this.opt("header")
                    }
                }, t.prototype.computeFooterOptions = function() {
                    return {
                        extraClasses: "fc-footer-toolbar",
                        layout: this.opt("footer")
                    }
                }, t.prototype.renderHeader = function() {
                    var t = this.header;
                    t.setToolbarOptions(this.computeHeaderOptions()), t.render(), t.el && this.el.prepend(t.el)
                }, t.prototype.renderFooter = function() {
                    var t = this.footer;
                    t.setToolbarOptions(this.computeFooterOptions()), t.render(), t.el && this.el.append(t.el)
                }, t.prototype.setToolbarsTitle = function(t) {
                    this.toolbarsManager.proxyCall("updateTitle", t)
                }, t.prototype.updateToolbarButtons = function(t) {
                    var e = this.getNow(),
                        n = this.view,
                        i = n.dateProfileGenerator.build(e),
                        r = n.dateProfileGenerator.buildPrev(n.get("dateProfile")),
                        o = n.dateProfileGenerator.buildNext(n.get("dateProfile"));
                    this.toolbarsManager.proxyCall(i.isValid && !t.currentUnzonedRange.containsDate(e) ? "enableButton" : "disableButton", "today"), this.toolbarsManager.proxyCall(r.isValid ? "enableButton" : "disableButton", "prev"), this.toolbarsManager.proxyCall(o.isValid ? "enableButton" : "disableButton", "next")
                }, t.prototype.queryToolbarsHeight = function() {
                    return this.toolbarsManager.items.reduce(function(t, e) {
                        return t + (e.el ? e.el.outerHeight(!0) : 0)
                    }, 0)
                }, t.prototype.select = function(t, e) {
                    this.view.select(this.buildSelectFootprint.apply(this, arguments))
                }, t.prototype.unselect = function() {
                    this.view && this.view.unselect()
                }, t.prototype.buildSelectFootprint = function(t, e) {
                    var n, i = this.moment(t).stripZone();
                    return n = e ? this.moment(e).stripZone() : i.hasTime() ? i.clone().add(this.defaultTimedEventDuration) : i.clone().add(this.defaultAllDayEventDuration), new m.default(new y.default(i, n), !i.hasTime())
                }, t.prototype.initMomentInternals = function() {
                    var o = this;
                    this.defaultAllDayEventDuration = i.duration(this.opt("defaultAllDayEventDuration")), this.defaultTimedEventDuration = i.duration(this.opt("defaultTimedEventDuration")), this.optionsManager.watch("buildingMomentLocale", ["?locale", "?monthNames", "?monthNamesShort", "?dayNames", "?dayNamesShort", "?firstDay", "?weekNumberCalculation"], function(t) {
                        var e, n = t.weekNumberCalculation,
                            i = t.firstDay;
                        "iso" === n && (n = "ISO");
                        var r = Object.create(g.getMomentLocaleData(t.locale));
                        t.monthNames && (r._months = t.monthNames), t.monthNamesShort && (r._monthsShort = t.monthNamesShort), t.dayNames && (r._weekdays = t.dayNames), t.dayNamesShort && (r._weekdaysShort = t.dayNamesShort), null == i && "ISO" === n && (i = 1), null != i && ((e = Object.create(r._week)).dow = i, r._week = e), "ISO" !== n && "local" !== n && "function" != typeof n || (r._fullCalendar_weekCalc = n), o.localeData = r, o.currentDate && o.localizeMoment(o.currentDate)
                    })
                }, t.prototype.moment = function() {
                    for (var t, e = [], n = 0; n < arguments.length; n++) e[n] = arguments[n];
                    return "local" === this.opt("timezone") ? (t = v.default.apply(null, e)).hasTime() && t.local() : t = "UTC" === this.opt("timezone") ? v.default.utc.apply(null, e) : v.default.parseZone.apply(null, e), this.localizeMoment(t), t
                }, t.prototype.msToMoment = function(t, e) {
                    var n = v.default.utc(t);
                    return e ? n.stripTime() : n = this.applyTimezone(n), this.localizeMoment(n), n
                }, t.prototype.msToUtcMoment = function(t, e) {
                    var n = v.default.utc(t);
                    return e && n.stripTime(), this.localizeMoment(n), n
                }, t.prototype.localizeMoment = function(t) {
                    t._locale = this.localeData
                }, t.prototype.getIsAmbigTimezone = function() {
                    return "local" !== this.opt("timezone") && "UTC" !== this.opt("timezone")
                }, t.prototype.applyTimezone = function(t) {
                    if (!t.hasTime()) return t.clone();
                    var e, n = this.moment(t.toArray()),
                        i = t.time().asMilliseconds() - n.time().asMilliseconds();
                    return i && (e = n.clone().add(i), t.time().asMilliseconds() - e.time().asMilliseconds() == 0 && (n = e)), n
                }, t.prototype.footprintToDateProfile = function(t, e) {
                    void 0 === e && (e = !1);
                    var n, i = v.default.utc(t.unzonedRange.startMs);
                    return e || (n = v.default.utc(t.unzonedRange.endMs)), t.isAllDay ? (i.stripTime(), n && n.stripTime()) : (i = this.applyTimezone(i), n && (n = this.applyTimezone(n))), new b.default(i, n, this)
                }, t.prototype.getNow = function() {
                    var t = this.opt("now");
                    return "function" == typeof t && (t = t()), this.moment(t).stripZone()
                }, t.prototype.humanizeDuration = function(t) {
                    return t.locale(this.opt("locale")).humanize()
                }, t.prototype.parseUnzonedRange = function(t) {
                    var e = null,
                        n = null;
                    return t.start && (e = this.moment(t.start).stripZone()), t.end && (n = this.moment(t.end).stripZone()), e || n ? e && n && n.isBefore(e) ? null : new y.default(e, n) : null
                }, t.prototype.initEventManager = function() {
                    var n = this,
                        i = new w.default(this),
                        t = this.opt("eventSources") || [],
                        e = this.opt("events");
                    this.eventManager = i, e && t.unshift(e), i.on("release", function(t) {
                        n.trigger("eventsReset", t)
                    }), i.freeze(), t.forEach(function(t) {
                        var e = E.default.parse(t, n);
                        e && i.addSource(e)
                    }), i.thaw()
                }, t.prototype.requestEvents = function(t, e) {
                    return this.eventManager.requestEvents(t, e, this.opt("timezone"), !this.opt("lazyFetching"))
                }, t.prototype.getEventEnd = function(t) {
                    return t.end ? t.end.clone() : this.getDefaultEventEnd(t.allDay, t.start)
                }, t.prototype.getDefaultEventEnd = function(t, e) {
                    var n = e.clone();
                    return t ? n.stripTime().add(this.defaultAllDayEventDuration) : n.add(this.defaultTimedEventDuration), this.getIsAmbigTimezone() && n.stripZone(), n
                }, t.prototype.rerenderEvents = function() {
                    this.view.flash("displayingEvents")
                }, t.prototype.refetchEvents = function() {
                    this.eventManager.refetchAllSources()
                }, t.prototype.renderEvents = function(t, e) {
                    this.eventManager.freeze();
                    for (var n = 0; n < t.length; n++) this.renderEvent(t[n], e);
                    this.eventManager.thaw()
                }, t.prototype.renderEvent = function(t, e) {
                    void 0 === e && (e = !1);
                    var n = this.eventManager,
                        i = S.default.parse(t, t.source || n.stickySource);
                    i && n.addEventDef(i, e)
                }, t.prototype.removeEvents = function(t) {
                    var e, n = this.eventManager,
                        i = [],
                        r = {};
                    if (null == t) n.removeAllEventDefs();
                    else {
                        for (n.getEventInstances().forEach(function(t) {
                                i.push(t.toLegacy())
                            }), i = H(i, t), e = 0; e < i.length; e++) r[this.eventManager.getEventDefByUid(i[e]._id).id] = !0;
                        for (e in n.freeze(), r) n.removeEventDefsById(e);
                        n.thaw()
                    }
                }, t.prototype.clientEvents = function(t) {
                    var e = [];
                    return this.eventManager.getEventInstances().forEach(function(t) {
                        e.push(t.toLegacy())
                    }), H(e, t)
                }, t.prototype.updateEvents = function(t) {
                    this.eventManager.freeze();
                    for (var e = 0; e < t.length; e++) this.updateEvent(t[e]);
                    this.eventManager.thaw()
                }, t.prototype.updateEvent = function(t) {
                    var e, n, i = this.eventManager.getEventDefByUid(t._id);
                    i instanceof C.default && (e = i.buildInstance(), n = R.default.createFromRawProps(e, t, null), this.eventManager.mutateEventsWithId(i.id, n))
                }, t.prototype.getEventSources = function() {
                    return this.eventManager.otherSources.slice()
                }, t.prototype.getEventSourceById = function(t) {
                    return this.eventManager.getSourceById(T.default.normalizeId(t))
                }, t.prototype.addEventSource = function(t) {
                    var e = E.default.parse(t, this);
                    e && this.eventManager.addSource(e)
                }, t.prototype.removeEventSources = function(t) {
                    var e, n, i = this.eventManager;
                    if (null == t) this.eventManager.removeAllSources();
                    else {
                        for (e = i.multiQuerySources(t), i.freeze(), n = 0; n < e.length; n++) i.removeSource(e[n]);
                        i.thaw()
                    }
                }, t.prototype.removeEventSource = function(t) {
                    var e, n = this.eventManager,
                        i = n.querySources(t);
                    for (n.freeze(), e = 0; e < i.length; e++) n.removeSource(i[e]);
                    n.thaw()
                }, t.prototype.refetchEventSources = function(t) {
                    var e, n = this.eventManager,
                        i = n.multiQuerySources(t);
                    for (n.freeze(), e = 0; e < i.length; e++) n.refetchSource(i[e]);
                    n.thaw()
                }, t.defaults = r.globalDefaults, t.englishDefaults = r.englishDefaults, t.rtlDefaults = r.rtlDefaults, t
            }();

        function H(t, e) {
            return null == e ? t : s.isFunction(e) ? t.filter(e) : (e += "", t.filter(function(t) {
                return t.id == e || t._id === e
            }))
        }
        e.default = I, u.default.mixInto(I), d.default.mixInto(I)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var p = n(0),
            c = n(4),
            h = n(5),
            i = function() {
                function t(t) {
                    this._view = t
                }
                return t.prototype.opt = function(t) {
                    return this._view.opt(t)
                }, t.prototype.trimHiddenDays = function(t) {
                    return this._view.trimHiddenDays(t)
                }, t.prototype.msToUtcMoment = function(t, e) {
                    return this._view.calendar.msToUtcMoment(t, e)
                }, t.prototype.buildPrev = function(t) {
                    var e = t.date.clone().startOf(t.currentRangeUnit).subtract(t.dateIncrement);
                    return this.build(e, -1)
                }, t.prototype.buildNext = function(t) {
                    var e = t.date.clone().startOf(t.currentRangeUnit).add(t.dateIncrement);
                    return this.build(e, 1)
                }, t.prototype.build = function(t, e, n) {
                    void 0 === n && (n = !1);
                    var i, r, o, s, a, l, u, d, c = !t.hasTime();
                    return i = this.buildValidRange(), i = this.trimHiddenDays(i), n && (t = this.msToUtcMoment(i.constrainDate(t), c)), s = this.buildCurrentRangeInfo(t, e), a = /^(year|month|week|day)$/.test(s.unit), l = this.buildRenderRange(this.trimHiddenDays(s.unzonedRange), s.unit, a), u = (l = this.trimHiddenDays(l)).clone(), this.opt("showNonCurrentDates") || (u = u.intersect(s.unzonedRange)), r = p.duration(this.opt("minTime")), o = p.duration(this.opt("maxTime")), (u = (u = this.adjustActiveRange(u, r, o)).intersect(i)) && (t = this.msToUtcMoment(u.constrainDate(t), c)), d = s.unzonedRange.intersectsWith(i), {
                        validUnzonedRange: i,
                        currentUnzonedRange: s.unzonedRange,
                        currentRangeUnit: s.unit,
                        isRangeAllDay: a,
                        activeUnzonedRange: u,
                        renderUnzonedRange: l,
                        minTime: r,
                        maxTime: o,
                        isValid: d,
                        date: t,
                        dateIncrement: this.buildDateIncrement(s.duration)
                    }
                }, t.prototype.buildValidRange = function() {
                    return this._view.getUnzonedRangeOption("validRange", this._view.calendar.getNow()) || new h.default
                }, t.prototype.buildCurrentRangeInfo = function(t, e) {
                    var n, i = this._view.viewSpec,
                        r = null,
                        o = null,
                        s = null;
                    return i.duration ? (r = i.duration, o = i.durationUnit, s = this.buildRangeFromDuration(t, e, r, o)) : (n = this.opt("dayCount")) ? (o = "day", s = this.buildRangeFromDayCount(t, e, n)) : (s = this.buildCustomVisibleRange(t)) ? o = c.computeGreatestUnit(s.getStart(), s.getEnd()) : (r = this.getFallbackDuration(), o = c.computeGreatestUnit(r), s = this.buildRangeFromDuration(t, e, r, o)), {
                        duration: r,
                        unit: o,
                        unzonedRange: s
                    }
                }, t.prototype.getFallbackDuration = function() {
                    return p.duration({
                        days: 1
                    })
                }, t.prototype.adjustActiveRange = function(t, e, n) {
                    var i = t.getStart(),
                        r = t.getEnd();
                    return this._view.usesMinMaxTime && (e < 0 && i.time(0).add(e), 864e5 < n && r.time(n - 864e5)), new h.default(i, r)
                }, t.prototype.buildRangeFromDuration = function(t, e, n, i) {
                    var r, o, s, a, l, u = this.opt("dateAlignment");

                    function d() {
                        s = t.clone().startOf(u), a = s.clone().add(n), l = new h.default(s, a)
                    }
                    return u || ((r = this.opt("dateIncrement")) ? (o = p.duration(r), u = o < n ? c.computeDurationGreatestUnit(o, r) : i) : u = i), n.as("days") <= 1 && this._view.isHiddenDay(s) && (s = this._view.skipHiddenDays(s, e)).startOf("day"), d(), this.trimHiddenDays(l) || (t = this._view.skipHiddenDays(t, e), d()), l
                }, t.prototype.buildRangeFromDayCount = function(t, e, n) {
                    var i, r = this.opt("dateAlignment"),
                        o = 0,
                        s = t.clone();
                    for (r && s.startOf(r), s.startOf("day"), i = (s = this._view.skipHiddenDays(s, e)).clone(); i.add(1, "day"), this._view.isHiddenDay(i) || o++, o < n;);
                    return new h.default(s, i)
                }, t.prototype.buildCustomVisibleRange = function(t) {
                    var e = this._view.getUnzonedRangeOption("visibleRange", this._view.calendar.applyTimezone(t));
                    return !e || null != e.startMs && null != e.endMs ? e : null
                }, t.prototype.buildRenderRange = function(t, e, n) {
                    return t.clone()
                }, t.prototype.buildDateIncrement = function(t) {
                    var e, n = this.opt("dateIncrement");
                    return n ? p.duration(n) : (e = this.opt("dateAlignment")) ? p.duration(1, e) : t || p.duration({
                        days: 1
                    })
                }, t
            }();
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            u = n(3),
            d = n(0),
            c = n(16),
            p = n(4),
            o = n(10),
            r = n(7),
            h = n(23),
            s = n(13),
            f = n(18),
            a = n(6),
            l = function(e) {
                function t() {
                    var t = null !== e && e.apply(this, arguments) || this;
                    return t.isDragging = !1, t
                }
                return i.__extends(t, e), t.prototype.end = function() {
                    this.dragListener && this.dragListener.endInteraction()
                }, t.prototype.bindToDocument = function() {
                    this.listenTo(u(document), {
                        dragstart: this.handleDragStart,
                        sortstart: this.handleDragStart
                    })
                }, t.prototype.unbindFromDocument = function() {
                    this.stopListeningTo(u(document))
                }, t.prototype.handleDragStart = function(t, e) {
                    var n, i;
                    this.opt("droppable") && (n = u((e ? e.item : null) || t.target), i = this.opt("dropAccept"), (u.isFunction(i) ? i.call(n[0], n) : n.is(i)) && (this.isDragging || this.listenToExternalDrag(n, t, e)))
                }, t.prototype.listenToExternalDrag = function(e, t, n) {
                    var r, o = this,
                        s = this.component,
                        a = this.view,
                        l = function(t) {
                            var e, n, i, r, o = c.dataAttrPrefix;
                            o && (o += "-");
                            (e = t.data(o + "event") || null) && (e = "object" == typeof e ? u.extend({}, e) : {}, null == (n = e.start) && (n = e.time), i = e.duration, r = e.stick, delete e.start, delete e.time, delete e.duration, delete e.stick);
                            null == n && (n = t.data(o + "start"));
                            null == n && (n = t.data(o + "time"));
                            null == i && (i = t.data(o + "duration"));
                            null == r && (r = t.data(o + "stick"));
                            return n = null != n ? d.duration(n) : null, i = null != i ? d.duration(i) : null, r = Boolean(r), {
                                eventProps: e,
                                startTime: n,
                                duration: i,
                                stick: r
                            }
                        }(e);
                    (this.dragListener = new h.default(s, {
                        interactionStart: function() {
                            o.isDragging = !0
                        },
                        hitOver: function(t) {
                            var e, n = !0,
                                i = t.component.getSafeHitFootprint(t);
                            i && (r = o.computeExternalDrop(i, l)) ? (e = new f.default(r.buildInstances()), n = l.eventProps ? s.isEventInstanceGroupAllowed(e) : s.isExternalInstanceGroupAllowed(e)) : n = !1, n || (r = null, p.disableCursor()), r && s.renderDrag(s.eventRangesToEventFootprints(e.sliceRenderRanges(s.dateProfile.renderUnzonedRange, a.calendar)))
                        },
                        hitOut: function() {
                            r = null
                        },
                        hitDone: function() {
                            p.enableCursor(), s.unrenderDrag()
                        },
                        interactionEnd: function(t) {
                            r && a.reportExternalDrop(r, Boolean(l.eventProps), Boolean(l.stick), e, t, n), o.isDragging = !1, o.dragListener = null
                        }
                    })).startDrag(t)
                }, t.prototype.computeExternalDrop = function(t, e) {
                    var n, i = this.view.calendar,
                        r = o.default.utc(t.unzonedRange.startMs).stripZone();
                    return t.isAllDay && (e.startTime ? r.time(e.startTime) : r.stripTime()), e.duration && (n = r.clone().add(e.duration)), r = i.applyTimezone(r), n && (n = i.applyTimezone(n)), s.default.parse(u.extend({}, e.eventProps, {
                        start: r,
                        end: n
                    }), new a.default(i))
                }, t
            }(n(15).default);
        e.default = l, r.default.mixInto(l), c.dataAttrPrefix = ""
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            o = n(3),
            v = n(4),
            a = n(37),
            l = n(50),
            s = n(23),
            i = function(i) {
                function t(t, e) {
                    var n = i.call(this, t) || this;
                    return n.isResizing = !1, n.eventPointing = e, n
                }
                return r.__extends(t, i), t.prototype.end = function() {
                    this.dragListener && this.dragListener.endInteraction()
                }, t.prototype.bindToEl = function(t) {
                    var e = this.component;
                    e.bindSegHandlerToEl(t, "mousedown", this.handleMouseDown.bind(this)), e.bindSegHandlerToEl(t, "touchstart", this.handleTouchStart.bind(this))
                }, t.prototype.handleMouseDown = function(t, e) {
                    this.component.canStartResize(t, e) && this.buildDragListener(t, o(e.target).is(".fc-start-resizer")).startInteraction(e, {
                        distance: 5
                    })
                }, t.prototype.handleTouchStart = function(t, e) {
                    this.component.canStartResize(t, e) && this.buildDragListener(t, o(e.target).is(".fc-start-resizer")).startInteraction(e)
                }, t.prototype.buildDragListener = function(a, l) {
                    var e, u, d = this,
                        c = this.component,
                        p = this.view,
                        h = p.calendar,
                        f = h.eventManager,
                        n = a.el,
                        g = a.footprint.eventDef,
                        i = a.footprint.eventInstance;
                    return this.dragListener = new s.default(c, {
                        scroll: this.opt("dragScroll"),
                        subjectEl: n,
                        interactionStart: function() {
                            e = !1
                        },
                        dragStart: function(t) {
                            e = !0, d.eventPointing.handleMouseout(a, t), d.segResizeStart(a, t)
                        },
                        hitOver: function(t, e, n) {
                            var i, r = !0,
                                o = c.getSafeHitFootprint(n),
                                s = c.getSafeHitFootprint(t);
                            o && s && (u = l ? d.computeEventStartResizeMutation(o, s, a.footprint) : d.computeEventEndResizeMutation(o, s, a.footprint)) ? (i = f.buildMutatedEventInstanceGroup(g.id, u), r = c.isEventInstanceGroupAllowed(i)) : r = !1, r ? u.isEmpty() && (u = null) : (u = null, v.disableCursor()), u && (p.hideEventsWithId(a.footprint.eventDef.id), p.renderEventResize(c.eventRangesToEventFootprints(i.sliceRenderRanges(c.dateProfile.renderUnzonedRange, h)), a))
                        },
                        hitOut: function() {
                            u = null
                        },
                        hitDone: function() {
                            p.unrenderEventResize(a), p.showEventsWithId(a.footprint.eventDef.id), v.enableCursor()
                        },
                        interactionEnd: function(t) {
                            e && d.segResizeStop(a, t), u && p.reportEventResize(i, u, n, t), d.dragListener = null
                        }
                    })
                }, t.prototype.segResizeStart = function(t, e) {
                    this.isResizing = !0, this.component.publiclyTrigger("eventResizeStart", {
                        context: t.el[0],
                        args: [t.footprint.getEventLegacy(), e, {}, this.view]
                    })
                }, t.prototype.segResizeStop = function(t, e) {
                    this.isResizing = !1, this.component.publiclyTrigger("eventResizeStop", {
                        context: t.el[0],
                        args: [t.footprint.getEventLegacy(), e, {}, this.view]
                    })
                }, t.prototype.computeEventStartResizeMutation = function(t, e, n) {
                    var i, r, o = n.componentFootprint.unzonedRange,
                        s = this.component.diffDates(e.unzonedRange.getStart(), t.unzonedRange.getStart());
                    return o.getStart().add(s) < o.getEnd() && ((i = new l.default).setStartDelta(s), (r = new a.default).setDateMutation(i), r)
                }, t.prototype.computeEventEndResizeMutation = function(t, e, n) {
                    var i, r, o = n.componentFootprint.unzonedRange,
                        s = this.component.diffDates(e.unzonedRange.getEnd(), t.unzonedRange.getEnd());
                    return o.getEnd().add(s) > o.getStart() && ((i = new l.default).setEndDelta(s), (r = new a.default).setDateMutation(i), r)
                }, t
            }(n(15).default);
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            y = n(4),
            o = n(37),
            u = n(50),
            s = n(54),
            m = n(23),
            b = n(244),
            i = function(i) {
                function t(t, e) {
                    var n = i.call(this, t) || this;
                    return n.isDragging = !1, n.eventPointing = e, n
                }
                return r.__extends(t, i), t.prototype.end = function() {
                    this.dragListener && this.dragListener.endInteraction()
                }, t.prototype.getSelectionDelay = function() {
                    var t = this.opt("eventLongPressDelay");
                    return null == t && (t = this.opt("longPressDelay")), t
                }, t.prototype.bindToEl = function(t) {
                    var e = this.component;
                    e.bindSegHandlerToEl(t, "mousedown", this.handleMousedown.bind(this)), e.bindSegHandlerToEl(t, "touchstart", this.handleTouchStart.bind(this))
                }, t.prototype.handleMousedown = function(t, e) {
                    !this.component.shouldIgnoreMouse() && this.component.canStartDrag(t, e) && this.buildDragListener(t).startInteraction(e, {
                        distance: 5
                    })
                }, t.prototype.handleTouchStart = function(t, e) {
                    var n = this.component,
                        i = {
                            delay: this.view.isEventDefSelected(t.footprint.eventDef) ? 0 : this.getSelectionDelay()
                        };
                    n.canStartDrag(t, e) ? this.buildDragListener(t).startInteraction(e, i) : n.canStartSelection(t, e) && this.buildSelectListener(t).startInteraction(e, i)
                }, t.prototype.buildSelectListener = function(t) {
                    var e = this,
                        n = this.view,
                        i = t.footprint.eventDef,
                        r = t.footprint.eventInstance;
                    if (this.dragListener) return this.dragListener;
                    var o = this.dragListener = new s.default({
                        dragStart: function(t) {
                            o.isTouch && !n.isEventDefSelected(i) && r && n.selectEventInstance(r)
                        },
                        interactionEnd: function(t) {
                            e.dragListener = null
                        }
                    });
                    return o
                }, t.prototype.buildDragListener = function(a) {
                    var e, l, u, d = this,
                        c = this.component,
                        p = this.view,
                        h = p.calendar,
                        f = h.eventManager,
                        n = a.el,
                        g = a.footprint.eventDef,
                        i = a.footprint.eventInstance;
                    if (this.dragListener) return this.dragListener;
                    var v = this.dragListener = new m.default(p, {
                        scroll: this.opt("dragScroll"),
                        subjectEl: n,
                        subjectCenter: !0,
                        interactionStart: function(t) {
                            a.component = c, e = !1, (l = new b.default(a.el, {
                                additionalClass: "fc-dragging",
                                parentEl: p.el,
                                opacity: v.isTouch ? null : d.opt("dragOpacity"),
                                revertDuration: d.opt("dragRevertDuration"),
                                zIndex: 2
                            })).hide(), l.start(t)
                        },
                        dragStart: function(t) {
                            v.isTouch && !p.isEventDefSelected(g) && i && p.selectEventInstance(i), e = !0, d.eventPointing.handleMouseout(a, t), d.segDragStart(a, t), p.hideEventsWithId(a.footprint.eventDef.id)
                        },
                        hitOver: function(t, e, n) {
                            var i, r, o, s = !0;
                            a.hit && (n = a.hit), i = n.component.getSafeHitFootprint(n), r = t.component.getSafeHitFootprint(t), i && r && (u = d.computeEventDropMutation(i, r, g)) ? (o = f.buildMutatedEventInstanceGroup(g.id, u), s = c.isEventInstanceGroupAllowed(o)) : s = !1, s || (u = null, y.disableCursor()), u && p.renderDrag(c.eventRangesToEventFootprints(o.sliceRenderRanges(c.dateProfile.renderUnzonedRange, h)), a, v.isTouch) ? l.hide() : l.show(), e && (u = null)
                        },
                        hitOut: function() {
                            p.unrenderDrag(a), l.show(), u = null
                        },
                        hitDone: function() {
                            y.enableCursor()
                        },
                        interactionEnd: function(t) {
                            delete a.component, l.stop(!u, function() {
                                e && (p.unrenderDrag(a), d.segDragStop(a, t)), p.showEventsWithId(a.footprint.eventDef.id), u && p.reportEventDrop(i, u, n, t)
                            }), d.dragListener = null
                        }
                    });
                    return v
                }, t.prototype.segDragStart = function(t, e) {
                    this.isDragging = !0, this.component.publiclyTrigger("eventDragStart", {
                        context: t.el[0],
                        args: [t.footprint.getEventLegacy(), e, {}, this.view]
                    })
                }, t.prototype.segDragStop = function(t, e) {
                    this.isDragging = !1, this.component.publiclyTrigger("eventDragStop", {
                        context: t.el[0],
                        args: [t.footprint.getEventLegacy(), e, {}, this.view]
                    })
                }, t.prototype.computeEventDropMutation = function(t, e, n) {
                    var i = new o.default;
                    return i.setDateMutation(this.computeEventDateMutation(t, e)), i
                }, t.prototype.computeEventDateMutation = function(t, e) {
                    var n, i, r = t.unzonedRange.getStart(),
                        o = e.unzonedRange.getStart(),
                        s = !1,
                        a = !1,
                        l = !1;
                    return t.isAllDay !== e.isAllDay && (s = !0, e.isAllDay ? (l = !0, r.stripTime()) : a = !0), n = this.component.diffDates(o, r), (i = new u.default).clearEnd = s, i.forceTimed = a, i.forceAllDay = l, i.setDateDelta(n), i
                }, t
            }(n(15).default);
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            l = n(4),
            r = n(23),
            o = n(12),
            s = n(5),
            a = function(n) {
                function t(t) {
                    var e = n.call(this, t) || this;
                    return e.dragListener = e.buildDragListener(), e
                }
                return i.__extends(t, n), t.prototype.end = function() {
                    this.dragListener.endInteraction()
                }, t.prototype.getDelay = function() {
                    var t = this.opt("selectLongPressDelay");
                    return null == t && (t = this.opt("longPressDelay")), t
                }, t.prototype.bindToEl = function(t) {
                    var e = this,
                        n = this.component,
                        i = this.dragListener;
                    n.bindDateHandlerToEl(t, "mousedown", function(t) {
                        e.opt("selectable") && !n.shouldIgnoreMouse() && i.startInteraction(t, {
                            distance: e.opt("selectMinDistance")
                        })
                    }), n.bindDateHandlerToEl(t, "touchstart", function(t) {
                        e.opt("selectable") && !n.shouldIgnoreTouch() && i.startInteraction(t, {
                            delay: e.getDelay()
                        })
                    }), l.preventSelection(t)
                }, t.prototype.buildDragListener = function() {
                    var o, s = this,
                        a = this.component;
                    return new r.default(a, {
                        scroll: this.opt("dragScroll"),
                        interactionStart: function() {
                            o = null
                        },
                        dragStart: function(t) {
                            s.view.unselect(t)
                        },
                        hitOver: function(t, e, n) {
                            var i, r;
                            n && (i = a.getSafeHitFootprint(n), r = a.getSafeHitFootprint(t), (o = i && r ? s.computeSelection(i, r) : null) ? a.renderSelectionFootprint(o) : !1 === o && l.disableCursor())
                        },
                        hitOut: function() {
                            o = null, a.unrenderSelection()
                        },
                        hitDone: function() {
                            l.enableCursor()
                        },
                        interactionEnd: function(t, e) {
                            !e && o && s.view.reportSelection(o, t)
                        }
                    })
                }, t.prototype.computeSelection = function(t, e) {
                    var n = this.computeSelectionFootprint(t, e);
                    return !(n && !this.isSelectionFootprintAllowed(n)) && n
                }, t.prototype.computeSelectionFootprint = function(t, e) {
                    var n = [t.unzonedRange.startMs, t.unzonedRange.endMs, e.unzonedRange.startMs, e.unzonedRange.endMs];
                    return n.sort(l.compareNumbers), new o.default(new s.default(n[0], n[3]), t.isAllDay)
                }, t.prototype.isSelectionFootprintAllowed = function(t) {
                    return this.component.dateProfile.validUnzonedRange.containsRange(t.unzonedRange) && this.view.calendar.constraints.isSelectionFootprintAllowed(t)
                }, t
            }(n(15).default);
        e.default = a
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i, r, o = n(2),
            s = n(0),
            l = n(3),
            u = n(4),
            d = n(39),
            a = n(41),
            c = n(227),
            p = n(61),
            h = function(a) {
                function t(t, e) {
                    var n = a.call(this, t, e) || this;
                    return n.usesMinMaxTime = !0, n.timeGrid = n.instantiateTimeGrid(), n.addChild(n.timeGrid), n.opt("allDaySlot") && (n.dayGrid = n.instantiateDayGrid(), n.addChild(n.dayGrid)), n.scroller = new d.default({
                        overflowX: "hidden",
                        overflowY: "auto"
                    }), n
                }
                return o.__extends(t, a), t.prototype.instantiateTimeGrid = function() {
                    var t = new this.timeGridClass(this);
                    return u.copyOwnProps(i, t), t
                }, t.prototype.instantiateDayGrid = function() {
                    var t = new this.dayGridClass(this);
                    return u.copyOwnProps(r, t), t
                }, t.prototype.renderSkeleton = function() {
                    var t, e;
                    this.el.addClass("fc-agenda-view").html(this.renderSkeletonHtml()), this.scroller.render(), t = this.scroller.el.addClass("fc-time-grid-container"), e = l('<div class="fc-time-grid" />').appendTo(t), this.el.find(".fc-body > tr > td").append(t), this.timeGrid.headContainerEl = this.el.find(".fc-head-container"), this.timeGrid.setElement(e), this.dayGrid && (this.dayGrid.setElement(this.el.find(".fc-day-grid")), this.dayGrid.bottomCoordPadding = this.dayGrid.el.next("hr").outerHeight())
                }, t.prototype.unrenderSkeleton = function() {
                    this.timeGrid.removeElement(), this.dayGrid && this.dayGrid.removeElement(), this.scroller.destroy()
                }, t.prototype.renderSkeletonHtml = function() {
                    var t = this.calendar.theme;
                    return '<table class="' + t.getClass("tableGrid") + '">' + (this.opt("columnHeader") ? '<thead class="fc-head"><tr><td class="fc-head-container ' + t.getClass("widgetHeader") + '">&nbsp;</td></tr></thead>' : "") + '<tbody class="fc-body"><tr><td class="' + t.getClass("widgetContent") + '">' + (this.dayGrid ? '<div class="fc-day-grid"/><hr class="fc-divider ' + t.getClass("widgetHeader") + '"/>' : "") + "</td></tr></tbody></table>"
                }, t.prototype.axisStyleAttr = function() {
                    return null != this.axisWidth ? 'style="width:' + this.axisWidth + 'px"' : ""
                }, t.prototype.getNowIndicatorUnit = function() {
                    return this.timeGrid.getNowIndicatorUnit()
                }, t.prototype.updateSize = function(t, e, n) {
                    var i, r, o;
                    if (a.prototype.updateSize.call(this, t, e, n), this.axisWidth = u.matchCellWidths(this.el.find(".fc-axis")), this.timeGrid.colEls) {
                        var s = this.el.find(".fc-row:not(.fc-scroller *)");
                        this.timeGrid.bottomRuleEl.hide(), this.scroller.clear(), u.uncompensateScroll(s), this.dayGrid && (this.dayGrid.removeSegPopover(), (i = this.opt("eventLimit")) && "number" != typeof i && (i = 5), i && this.dayGrid.limitRows(i)), e || (r = this.computeScrollerHeight(t), this.scroller.setHeight(r), ((o = this.scroller.getScrollbarWidths()).left || o.right) && (u.compensateScroll(s, o), r = this.computeScrollerHeight(t), this.scroller.setHeight(r)), this.scroller.lockOverflow(o), this.timeGrid.getTotalSlatHeight() < r && this.timeGrid.bottomRuleEl.show())
                    } else e || (r = this.computeScrollerHeight(t), this.scroller.setHeight(r))
                }, t.prototype.computeScrollerHeight = function(t) {
                    return t - u.subtractInnerElHeight(this.el, this.scroller.el)
                }, t.prototype.computeInitialDateScroll = function() {
                    var t = s.duration(this.opt("scrollTime")),
                        e = this.timeGrid.computeTimeTop(t);
                    return (e = Math.ceil(e)) && e++, {
                        top: e
                    }
                }, t.prototype.queryDateScroll = function() {
                    return {
                        top: this.scroller.getScrollTop()
                    }
                }, t.prototype.applyDateScroll = function(t) {
                    void 0 !== t.top && this.scroller.setScrollTop(t.top)
                }, t.prototype.getHitFootprint = function(t) {
                    return t.component.getHitFootprint(t)
                }, t.prototype.getHitEl = function(t) {
                    return t.component.getHitEl(t)
                }, t.prototype.executeEventRender = function(t) {
                    var e, n, i = {},
                        r = {};
                    for (e in t)(n = t[e]).getEventDef().isAllDay() ? i[e] = n : r[e] = n;
                    this.timeGrid.executeEventRender(r), this.dayGrid && this.dayGrid.executeEventRender(i)
                }, t.prototype.renderDrag = function(t, e, n) {
                    var i = f(t),
                        r = !1;
                    return r = this.timeGrid.renderDrag(i.timed, e, n), this.dayGrid && (r = this.dayGrid.renderDrag(i.allDay, e, n) || r), r
                }, t.prototype.renderEventResize = function(t, e, n) {
                    var i = f(t);
                    this.timeGrid.renderEventResize(i.timed, e, n), this.dayGrid && this.dayGrid.renderEventResize(i.allDay, e, n)
                }, t.prototype.renderSelectionFootprint = function(t) {
                    t.isAllDay ? this.dayGrid && this.dayGrid.renderSelectionFootprint(t) : this.timeGrid.renderSelectionFootprint(t)
                }, t
            }(a.default);

        function f(t) {
            var e, n = [],
                i = [];
            for (e = 0; e < t.length; e++) t[e].componentFootprint.isAllDay ? n.push(t[e]) : i.push(t[e]);
            return {
                allDay: n,
                timed: i
            }
        }(e.default = h).prototype.timeGridClass = c.default, h.prototype.dayGridClass = p.default, i = {
            renderHeadIntroHtml: function() {
                var t, e = this.view,
                    n = e.calendar,
                    i = n.msToUtcMoment(this.dateProfile.renderUnzonedRange.startMs, !0);
                return this.opt("weekNumbers") ? (t = i.format(this.opt("smallWeekFormat")), '<th class="fc-axis fc-week-number ' + n.theme.getClass("widgetHeader") + '" ' + e.axisStyleAttr() + ">" + e.buildGotoAnchorHtml({
                    date: i,
                    type: "week",
                    forceOff: 1 < this.colCnt
                }, u.htmlEscape(t)) + "</th>") : '<th class="fc-axis ' + n.theme.getClass("widgetHeader") + '" ' + e.axisStyleAttr() + "></th>"
            },
            renderBgIntroHtml: function() {
                var t = this.view;
                return '<td class="fc-axis ' + t.calendar.theme.getClass("widgetContent") + '" ' + t.axisStyleAttr() + "></td>"
            },
            renderIntroHtml: function() {
                return '<td class="fc-axis" ' + this.view.axisStyleAttr() + "></td>"
            }
        }, r = {
            renderBgIntroHtml: function() {
                var t = this.view;
                return '<td class="fc-axis ' + t.calendar.theme.getClass("widgetContent") + '" ' + t.axisStyleAttr() + "><span>" + t.getAllDayHtml() + "</span></td>"
            },
            renderIntroHtml: function() {
                return '<td class="fc-axis" ' + this.view.axisStyleAttr() + "></td>"
            }
        }
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            o = n(3),
            c = n(0),
            p = n(4),
            i = n(40),
            s = n(56),
            a = n(60),
            l = n(55),
            u = n(53),
            d = n(5),
            h = n(12),
            f = n(246),
            g = n(247),
            v = n(248),
            y = [{
                hours: 1
            }, {
                minutes: 30
            }, {
                minutes: 15
            }, {
                seconds: 30
            }, {
                seconds: 15
            }],
            m = function(i) {
                function t(t) {
                    var e = i.call(this, t) || this;
                    return e.processOptions(), e
                }
                return r.__extends(t, i), t.prototype.componentFootprintToSegs = function(t) {
                    var e, n = this.sliceRangeByTimes(t.unzonedRange);
                    for (e = 0; e < n.length; e++) this.isRTL ? n[e].col = this.daysPerRow - 1 - n[e].dayIndex : n[e].col = n[e].dayIndex;
                    return n
                }, t.prototype.sliceRangeByTimes = function(t) {
                    var e, n, i = [];
                    for (n = 0; n < this.daysPerRow; n++)(e = t.intersect(this.dayRanges[n])) && i.push({
                        startMs: e.startMs,
                        endMs: e.endMs,
                        isStart: e.isStart,
                        isEnd: e.isEnd,
                        dayIndex: n
                    });
                    return i
                }, t.prototype.processOptions = function() {
                    var t, e = this.opt("slotDuration"),
                        n = this.opt("snapDuration");
                    e = c.duration(e), n = n ? c.duration(n) : e, this.slotDuration = e, this.snapDuration = n, this.snapsPerSlot = e / n, t = this.opt("slotLabelFormat"), o.isArray(t) && (t = t[t.length - 1]), this.labelFormat = t || this.opt("smallTimeFormat"), t = this.opt("slotLabelInterval"), this.labelInterval = t ? c.duration(t) : this.computeLabelInterval(e)
                }, t.prototype.computeLabelInterval = function(t) {
                    var e, n, i;
                    for (e = y.length - 1; 0 <= e; e--)
                        if (n = c.duration(y[e]), i = p.divideDurationByDuration(n, t), p.isInt(i) && 1 < i) return n;
                    return c.duration(t)
                }, t.prototype.renderDates = function(t) {
                    this.dateProfile = t, this.updateDayTable(), this.renderSlats(), this.renderColumns()
                }, t.prototype.unrenderDates = function() {
                    this.unrenderColumns()
                }, t.prototype.renderSkeleton = function() {
                    var t = this.view.calendar.theme;
                    this.el.html('<div class="fc-bg"></div><div class="fc-slats"></div><hr class="fc-divider ' + t.getClass("widgetHeader") + '" style="display:none" />'), this.bottomRuleEl = this.el.find("hr")
                }, t.prototype.renderSlats = function() {
                    var t = this.view.calendar.theme;
                    this.slatContainerEl = this.el.find("> .fc-slats").html('<table class="' + t.getClass("tableGrid") + '">' + this.renderSlatRowHtml() + "</table>"), this.slatEls = this.slatContainerEl.find("tr"), this.slatCoordCache = new u.default({
                        els: this.slatEls,
                        isVertical: !0
                    })
                }, t.prototype.renderSlatRowHtml = function() {
                    for (var t, e, n, i = this.view, r = i.calendar, o = r.theme, s = this.isRTL, a = this.dateProfile, l = "", u = c.duration(+a.minTime), d = c.duration(0); u < a.maxTime;) t = r.msToUtcMoment(a.renderUnzonedRange.startMs).time(u), e = p.isInt(p.divideDurationByDuration(d, this.labelInterval)), n = '<td class="fc-axis fc-time ' + o.getClass("widgetContent") + '" ' + i.axisStyleAttr() + ">" + (e ? "<span>" + p.htmlEscape(t.format(this.labelFormat)) + "</span>" : "") + "</td>", l += '<tr data-time="' + t.format("HH:mm:ss") + '"' + (e ? "" : ' class="fc-minor"') + ">" + (s ? "" : n) + '<td class="' + o.getClass("widgetContent") + '"/>' + (s ? n : "") + "</tr>", u.add(this.slotDuration), d.add(this.slotDuration);
                    return l
                }, t.prototype.renderColumns = function() {
                    var e = this.dateProfile,
                        t = this.view.calendar.theme;
                    this.dayRanges = this.dayDates.map(function(t) {
                        return new d.default(t.clone().add(e.minTime), t.clone().add(e.maxTime))
                    }), this.headContainerEl && this.headContainerEl.html(this.renderHeadHtml()), this.el.find("> .fc-bg").html('<table class="' + t.getClass("tableGrid") + '">' + this.renderBgTrHtml(0) + "</table>"), this.colEls = this.el.find(".fc-day, .fc-disabled-day"), this.colCoordCache = new u.default({
                        els: this.colEls,
                        isHorizontal: !0
                    }), this.renderContentSkeleton()
                }, t.prototype.unrenderColumns = function() {
                    this.unrenderContentSkeleton()
                }, t.prototype.renderContentSkeleton = function() {
                    var t, e, n = "";
                    for (t = 0; t < this.colCnt; t++) n += '<td><div class="fc-content-col"><div class="fc-event-container fc-helper-container"></div><div class="fc-event-container"></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"></div></div></td>';
                    e = this.contentSkeletonEl = o('<div class="fc-content-skeleton"><table><tr>' + n + "</tr></table></div>"), this.colContainerEls = e.find(".fc-content-col"), this.helperContainerEls = e.find(".fc-helper-container"), this.fgContainerEls = e.find(".fc-event-container:not(.fc-helper-container)"), this.bgContainerEls = e.find(".fc-bgevent-container"), this.highlightContainerEls = e.find(".fc-highlight-container"), this.businessContainerEls = e.find(".fc-business-container"), this.bookendCells(e.find("tr")), this.el.append(e)
                }, t.prototype.unrenderContentSkeleton = function() {
                    this.contentSkeletonEl && (this.contentSkeletonEl.remove(), this.contentSkeletonEl = null, this.colContainerEls = null, this.helperContainerEls = null, this.fgContainerEls = null, this.bgContainerEls = null, this.highlightContainerEls = null, this.businessContainerEls = null)
                }, t.prototype.groupSegsByCol = function(t) {
                    var e, n = [];
                    for (e = 0; e < this.colCnt; e++) n.push([]);
                    for (e = 0; e < t.length; e++) n[t[e].col].push(t[e]);
                    return n
                }, t.prototype.attachSegsByCol = function(t, e) {
                    var n, i, r;
                    for (n = 0; n < this.colCnt; n++)
                        for (i = t[n], r = 0; r < i.length; r++) e.eq(n).append(i[r].el)
                }, t.prototype.getNowIndicatorUnit = function() {
                    return "minute"
                }, t.prototype.renderNowIndicator = function(t) {
                    if (this.colContainerEls) {
                        var e, n = this.componentFootprintToSegs(new h.default(new d.default(t, t.valueOf() + 1), !1)),
                            i = this.computeDateTop(t, t),
                            r = [];
                        for (e = 0; e < n.length; e++) r.push(o('<div class="fc-now-indicator fc-now-indicator-line"></div>').css("top", i).appendTo(this.colContainerEls.eq(n[e].col))[0]);
                        0 < n.length && r.push(o('<div class="fc-now-indicator fc-now-indicator-arrow"></div>').css("top", i).appendTo(this.el.find(".fc-content-skeleton"))[0]), this.nowIndicatorEls = o(r)
                    }
                }, t.prototype.unrenderNowIndicator = function() {
                    this.nowIndicatorEls && (this.nowIndicatorEls.remove(), this.nowIndicatorEls = null)
                }, t.prototype.updateSize = function(t, e, n) {
                    i.prototype.updateSize.call(this, t, e, n), this.slatCoordCache.build(), n && this.updateSegVerticals([].concat(this.eventRenderer.getSegs(), this.businessSegs || []))
                }, t.prototype.getTotalSlatHeight = function() {
                    return this.slatContainerEl.outerHeight()
                }, t.prototype.computeDateTop = function(t, e) {
                    return this.computeTimeTop(c.duration(t - e.clone().stripTime()))
                }, t.prototype.computeTimeTop = function(t) {
                    var e, n, i = this.slatEls.length,
                        r = (t - this.dateProfile.minTime) / this.slotDuration;
                    return r = Math.max(0, r), r = Math.min(i, r), e = Math.floor(r), n = r - (e = Math.min(e, i - 1)), this.slatCoordCache.getTopPosition(e) + this.slatCoordCache.getHeight(e) * n
                }, t.prototype.updateSegVerticals = function(t) {
                    this.computeSegVerticals(t), this.assignSegVerticals(t)
                }, t.prototype.computeSegVerticals = function(t) {
                    var e, n, i, r = this.opt("agendaEventMinHeight");
                    for (e = 0; e < t.length; e++) n = t[e], i = this.dayDates[n.dayIndex], n.top = this.computeDateTop(n.startMs, i), n.bottom = Math.max(n.top + r, this.computeDateTop(n.endMs, i))
                }, t.prototype.assignSegVerticals = function(t) {
                    var e, n;
                    for (e = 0; e < t.length; e++)(n = t[e]).el.css(this.generateSegVerticalCss(n))
                }, t.prototype.generateSegVerticalCss = function(t) {
                    return {
                        top: t.top,
                        bottom: -t.bottom
                    }
                }, t.prototype.prepareHits = function() {
                    this.colCoordCache.build(), this.slatCoordCache.build()
                }, t.prototype.releaseHits = function() {
                    this.colCoordCache.clear()
                }, t.prototype.queryHit = function(t, e) {
                    var n = this.snapsPerSlot,
                        i = this.colCoordCache,
                        r = this.slatCoordCache;
                    if (i.isLeftInBounds(t) && r.isTopInBounds(e)) {
                        var o = i.getHorizontalIndex(t),
                            s = r.getVerticalIndex(e);
                        if (null != o && null != s) {
                            var a = r.getTopOffset(s),
                                l = r.getHeight(s),
                                u = (e - a) / l,
                                d = Math.floor(u * n),
                                c = a + d / n * l,
                                p = a + (d + 1) / n * l;
                            return {
                                col: o,
                                snap: s * n + d,
                                component: this,
                                left: i.getLeftOffset(o),
                                right: i.getRightOffset(o),
                                top: c,
                                bottom: p
                            }
                        }
                    }
                }, t.prototype.getHitFootprint = function(t) {
                    var e, n = this.getCellDate(0, t.col),
                        i = this.computeSnapTime(t.snap);
                    return n.time(i), e = n.clone().add(this.snapDuration), new h.default(new d.default(n, e), !1)
                }, t.prototype.computeSnapTime = function(t) {
                    return c.duration(this.dateProfile.minTime + this.snapDuration * t)
                }, t.prototype.getHitEl = function(t) {
                    return this.colEls.eq(t.col)
                }, t.prototype.renderDrag = function(t, e, n) {
                    var i;
                    if (e) {
                        if (t.length) return this.helperRenderer.renderEventDraggingFootprints(t, e, n), !0
                    } else
                        for (i = 0; i < t.length; i++) this.renderHighlight(t[i].componentFootprint)
                }, t.prototype.unrenderDrag = function() {
                    this.unrenderHighlight(), this.helperRenderer.unrender()
                }, t.prototype.renderEventResize = function(t, e, n) {
                    this.helperRenderer.renderEventResizingFootprints(t, e, n)
                }, t.prototype.unrenderEventResize = function() {
                    this.helperRenderer.unrender()
                }, t.prototype.renderSelectionFootprint = function(t) {
                    this.opt("selectHelper") ? this.helperRenderer.renderComponentFootprint(t) : this.renderHighlight(t)
                }, t.prototype.unrenderSelection = function() {
                    this.helperRenderer.unrender(), this.unrenderHighlight()
                }, t
            }(i.default);
        (e.default = m).prototype.eventRendererClass = f.default, m.prototype.businessHourRendererClass = s.default, m.prototype.helperRendererClass = g.default, m.prototype.fillRendererClass = v.default, a.default.mixInto(m), l.default.mixInto(m)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            a = n(5),
            r = function(s) {
                function t() {
                    return null !== s && s.apply(this, arguments) || this
                }
                return i.__extends(t, s), t.prototype.buildRenderRange = function(t, e, n) {
                    var i = s.prototype.buildRenderRange.call(this, t, e, n),
                        r = this.msToUtcMoment(i.startMs, n),
                        o = this.msToUtcMoment(i.endMs, n);
                    return /^(year|month)$/.test(e) && (r.startOf("week"), o.weekday() && o.add(1, "week").startOf("week")), new a.default(r, o)
                }, t
            }(n(221).default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(0),
            o = n(4),
            s = n(62),
            a = n(253),
            l = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.setGridHeight = function(t, e) {
                    e && (t *= this.dayGrid.rowCnt / 6), o.distributeHeight(this.dayGrid.rowEls, t, !e)
                }, e.prototype.isDateInOtherMonth = function(t, e) {
                    return t.month() !== r.utc(e.currentUnzonedRange.startMs).month()
                }, e
            }(s.default);
        (e.default = l).prototype.dateProfileGeneratorClass = a.default
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            a = n(3),
            o = n(4),
            s = n(5),
            i = n(41),
            l = n(39),
            u = n(254),
            d = n(255),
            c = function(i) {
                function t(t, e) {
                    var n = i.call(this, t, e) || this;
                    return n.segSelector = ".fc-list-item", n.scroller = new l.default({
                        overflowX: "hidden",
                        overflowY: "auto"
                    }), n
                }
                return r.__extends(t, i), t.prototype.renderSkeleton = function() {
                    this.el.addClass("fc-list-view " + this.calendar.theme.getClass("listView")), this.scroller.render(), this.scroller.el.appendTo(this.el), this.contentEl = this.scroller.scrollEl
                }, t.prototype.unrenderSkeleton = function() {
                    this.scroller.destroy()
                }, t.prototype.updateSize = function(t, e, n) {
                    i.prototype.updateSize.call(this, t, e, n), this.scroller.clear(), e || this.scroller.setHeight(this.computeScrollerHeight(t))
                }, t.prototype.computeScrollerHeight = function(t) {
                    return t - o.subtractInnerElHeight(this.el, this.scroller.el)
                }, t.prototype.renderDates = function(t) {
                    for (var e = this.calendar, n = e.msToUtcMoment(t.renderUnzonedRange.startMs, !0), i = e.msToUtcMoment(t.renderUnzonedRange.endMs, !0), r = [], o = []; n < i;) r.push(n.clone()), o.push(new s.default(n, n.clone().add(1, "day"))), n.add(1, "day");
                    this.dayDates = r, this.dayRanges = o
                }, t.prototype.componentFootprintToSegs = function(t) {
                    var e, n, i, r = this.dayRanges,
                        o = [];
                    for (e = 0; e < r.length; e++)
                        if ((n = t.unzonedRange.intersect(r[e])) && (i = {
                                startMs: n.startMs,
                                endMs: n.endMs,
                                isStart: n.isStart,
                                isEnd: n.isEnd,
                                dayIndex: e
                            }, o.push(i), !i.isEnd && !t.isAllDay && e + 1 < r.length && t.unzonedRange.endMs < r[e + 1].startMs + this.nextDayThreshold)) {
                            i.endMs = t.unzonedRange.endMs, i.isEnd = !0;
                            break
                        }
                    return o
                }, t.prototype.renderEmptyMessage = function() {
                    this.contentEl.html('<div class="fc-list-empty-wrap2"><div class="fc-list-empty-wrap1"><div class="fc-list-empty">' + o.htmlEscape(this.opt("noEventsMessage")) + "</div></div></div>")
                }, t.prototype.renderSegList = function(t) {
                    var e, n, i, r = this.groupSegsByDay(t),
                        o = a('<table class="fc-list-table ' + this.calendar.theme.getClass("tableList") + '"><tbody/></table>'),
                        s = o.find("tbody");
                    for (e = 0; e < r.length; e++)
                        if (n = r[e])
                            for (s.append(this.dayHeaderHtml(this.dayDates[e])), this.eventRenderer.sortEventSegs(n), i = 0; i < n.length; i++) s.append(n[i].el);
                    this.contentEl.empty().append(o)
                }, t.prototype.groupSegsByDay = function(t) {
                    var e, n, i = [];
                    for (e = 0; e < t.length; e++)(i[(n = t[e]).dayIndex] || (i[n.dayIndex] = [])).push(n);
                    return i
                }, t.prototype.dayHeaderHtml = function(t) {
                    var e = this.opt("listDayFormat"),
                        n = this.opt("listDayAltFormat");
                    return '<tr class="fc-list-heading" data-date="' + t.format("YYYY-MM-DD") + '"><td class="' + (this.calendar.theme.getClass("tableListHeading") || this.calendar.theme.getClass("widgetHeader")) + '" colspan="3">' + (e ? this.buildGotoAnchorHtml(t, {
                        class: "fc-list-heading-main"
                    }, o.htmlEscape(t.format(e))) : "") + (n ? this.buildGotoAnchorHtml(t, {
                        class: "fc-list-heading-alt"
                    }, o.htmlEscape(t.format(n))) : "") + "</td></tr>"
                }, t
            }(i.default);
        (e.default = c).prototype.eventRendererClass = u.default, c.prototype.eventPointingClass = d.default
    }, , , , , , function(t, e, n) {
        var l = n(3),
            i = n(16),
            u = n(4),
            d = n(220);
        n(10), n(47), n(256), n(257), n(260), n(261), n(262), n(263), l.fullCalendar = i, l.fn.fullCalendar = function(o) {
            var s = Array.prototype.slice.call(arguments, 1),
                a = this;
            return this.each(function(t, e) {
                var n, i = l(e),
                    r = i.data("fullCalendar");
                "string" == typeof o ? "getCalendar" === o ? t || (a = r) : "destroy" === o ? r && (r.destroy(), i.removeData("fullCalendar")) : r ? l.isFunction(r[o]) ? (n = r[o].apply(r, s), t || (a = n), "destroy" === o && i.removeData("fullCalendar")) : u.warn("'" + o + "' is an unknown FullCalendar method.") : u.warn("Attempting to call a FullCalendar method on an element with no calendar.") : r || (r = new d.default(i, o), i.data("fullCalendar", r), r.render())
            }), a
        }, t.exports = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.setElement = function(t) {
                    this.el = t, this.bindGlobalHandlers(), this.renderSkeleton(), this.set("isInDom", !0)
                }, e.prototype.removeElement = function() {
                    this.unset("isInDom"), this.unrenderSkeleton(), this.unbindGlobalHandlers(), this.el.remove()
                }, e.prototype.bindGlobalHandlers = function() {}, e.prototype.unbindGlobalHandlers = function() {}, e.prototype.renderSkeleton = function() {}, e.prototype.unrenderSkeleton = function() {}, e
            }(n(48).default);
        e.default = r
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var n = function() {
            function t(t) {
                this.items = t || []
            }
            return t.prototype.proxyCall = function(e) {
                for (var n = [], t = 1; t < arguments.length; t++) n[t - 1] = arguments[t];
                var i = [];
                return this.items.forEach(function(t) {
                    i.push(t[e].apply(t, n))
                }), i
            }, t
        }();
        e.default = n
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var w = n(3),
            D = n(4),
            i = function() {
                function t(t, e) {
                    this.el = null, this.viewsWithButtons = [], this.calendar = t, this.toolbarOptions = e
                }
                return t.prototype.setToolbarOptions = function(t) {
                    this.toolbarOptions = t
                }, t.prototype.render = function() {
                    var t = this.toolbarOptions.layout,
                        e = this.el;
                    t ? (e ? e.empty() : e = this.el = w("<div class='fc-toolbar " + this.toolbarOptions.extraClasses + "'/>"), e.append(this.renderSection("left")).append(this.renderSection("right")).append(this.renderSection("center")).append('<div class="fc-clear"/>')) : this.removeElement()
                }, t.prototype.removeElement = function() {
                    this.el && (this.el.remove(), this.el = null)
                }, t.prototype.renderSection = function(t) {
                    var h = this,
                        f = this.calendar,
                        g = f.theme,
                        e = f.optionsManager,
                        v = f.viewSpecManager,
                        i = w('<div class="fc-' + t + '"/>'),
                        n = this.toolbarOptions.layout[t],
                        y = e.get("customButtons") || {},
                        m = e.overrides.buttonText || {},
                        b = e.get("buttonText") || {};
                    return n && w.each(n.split(" "), function(t, e) {
                        var n, c = w(),
                            p = !0;
                        w.each(e.split(","), function(t, e) {
                            var n, i, r, o, s, a, l, u, d;
                            "title" === e ? (c = c.add(w("<h2>&nbsp;</h2>")), p = !1) : ((n = y[e]) ? (r = function(t) {
                                n.click && n.click.call(u[0], t)
                            }, (o = g.getCustomButtonIconClass(n)) || (o = g.getIconClass(e)) || (s = n.text)) : (i = v.getViewSpec(e)) ? (h.viewsWithButtons.push(e), r = function() {
                                f.changeView(e)
                            }, (s = i.buttonTextOverride) || (o = g.getIconClass(e)) || (s = i.buttonTextDefault)) : f[e] && (r = function() {
                                f[e]()
                            }, (s = m[e]) || (o = g.getIconClass(e)) || (s = b[e])), r && (l = ["fc-" + e + "-button", g.getClass("button"), g.getClass("stateDefault")], s ? (a = D.htmlEscape(s), d = "") : o && (a = "<span class='" + o + "'></span>", d = ' aria-label="' + e + '"'), u = w('<button type="button" class="' + l.join(" ") + '"' + d + ">" + a + "</button>").click(function(t) {
                                u.hasClass(g.getClass("stateDisabled")) || (r(t), (u.hasClass(g.getClass("stateActive")) || u.hasClass(g.getClass("stateDisabled"))) && u.removeClass(g.getClass("stateHover")))
                            }).mousedown(function() {
                                u.not("." + g.getClass("stateActive")).not("." + g.getClass("stateDisabled")).addClass(g.getClass("stateDown"))
                            }).mouseup(function() {
                                u.removeClass(g.getClass("stateDown"))
                            }).hover(function() {
                                u.not("." + g.getClass("stateActive")).not("." + g.getClass("stateDisabled")).addClass(g.getClass("stateHover"))
                            }, function() {
                                u.removeClass(g.getClass("stateHover")).removeClass(g.getClass("stateDown"))
                            }), c = c.add(u)))
                        }), p && c.first().addClass(g.getClass("cornerLeft")).end().last().addClass(g.getClass("cornerRight")).end(), 1 < c.length ? (n = w("<div/>"), p && n.addClass(g.getClass("buttonGroup")), n.append(c), i.append(n)) : i.append(c)
                    }), i
                }, t.prototype.updateTitle = function(t) {
                    this.el && this.el.find("h2").text(t)
                }, t.prototype.activateButton = function(t) {
                    this.el && this.el.find(".fc-" + t + "-button").addClass(this.calendar.theme.getClass("stateActive"))
                }, t.prototype.deactivateButton = function(t) {
                    this.el && this.el.find(".fc-" + t + "-button").removeClass(this.calendar.theme.getClass("stateActive"))
                }, t.prototype.disableButton = function(t) {
                    this.el && this.el.find(".fc-" + t + "-button").prop("disabled", !0).addClass(this.calendar.theme.getClass("stateDisabled"))
                }, t.prototype.enableButton = function(t) {
                    this.el && this.el.find(".fc-" + t + "-button").prop("disabled", !1).removeClass(this.calendar.theme.getClass("stateDisabled"))
                }, t.prototype.getViewsWithButtons = function() {
                    return this.viewsWithButtons
                }, t
            }();
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            o = n(3),
            s = n(4),
            a = n(32),
            l = n(31),
            i = function(i) {
                function t(t, e) {
                    var n = i.call(this) || this;
                    return n._calendar = t, n.overrides = o.extend({}, e), n.dynamicOverrides = {}, n.compute(), n
                }
                return r.__extends(t, i), t.prototype.add = function(t) {
                    var e, n = 0;
                    for (e in this.recordOverrides(t), t) n++;
                    if (1 === n) {
                        if ("height" === e || "contentHeight" === e || "aspectRatio" === e) return void this._calendar.updateViewSize(!0);
                        if ("defaultDate" === e) return;
                        if ("businessHours" === e) return;
                        if (/^(event|select)(Overlap|Constraint|Allow)$/.test(e)) return;
                        if ("timezone" === e) return void this._calendar.view.flash("initialEvents")
                    }
                    this._calendar.renderHeader(), this._calendar.renderFooter(), this._calendar.viewsByType = {}, this._calendar.reinitView()
                }, t.prototype.compute = function() {
                    var t, e, n, i;
                    t = s.firstDefined(this.dynamicOverrides.locale, this.overrides.locale), (e = l.localeOptionHash[t]) || (t = a.globalDefaults.locale, e = l.localeOptionHash[t] || {}), n = s.firstDefined(this.dynamicOverrides.isRTL, this.overrides.isRTL, e.isRTL, a.globalDefaults.isRTL) ? a.rtlDefaults : {}, this.dirDefaults = n, this.localeDefaults = e, i = a.mergeOptions([a.globalDefaults, n, e, this.overrides, this.dynamicOverrides]), l.populateInstanceComputableOptions(i), this.reset(i)
                }, t.prototype.recordOverrides = function(t) {
                    var e;
                    for (e in t) this.dynamicOverrides[e] = t[e];
                    this._calendar.viewSpecManager.clearCache(), this.compute()
                }, t
            }(n(48).default);
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var c = n(0),
            r = n(3),
            p = n(22),
            h = n(4),
            f = n(32),
            i = n(31),
            o = function() {
                function t(t, e) {
                    this.optionsManager = t, this._calendar = e, this.clearCache()
                }
                return t.prototype.clearCache = function() {
                    this.viewSpecCache = {}
                }, t.prototype.getViewSpec = function(t) {
                    var e = this.viewSpecCache;
                    return e[t] || (e[t] = this.buildViewSpec(t))
                }, t.prototype.getUnitViewSpec = function(t) {
                    var e, n, i;
                    if (-1 !== r.inArray(t, h.unitsDesc))
                        for (e = this._calendar.header.getViewsWithButtons(), r.each(p.viewHash, function(t) {
                                e.push(t)
                            }), n = 0; n < e.length; n++)
                            if ((i = this.getViewSpec(e[n])) && i.singleUnit === t) return i
                }, t.prototype.buildViewSpec = function(t) {
                    for (var e, n, i, r, o, s = this.optionsManager.overrides.views || {}, a = [], l = [], u = [], d = t; d;) e = p.viewHash[d], n = s[d], d = null, "function" == typeof e && (e = {
                        class: e
                    }), e && (a.unshift(e), l.unshift(e.defaults || {}), i = i || e.duration, d = d || e.type), n && (u.unshift(n), i = i || n.duration, d = d || n.type);
                    return (e = h.mergeProps(a)).type = t, !!e.class && ((i = i || this.optionsManager.dynamicOverrides.duration || this.optionsManager.overrides.duration) && (r = c.duration(i)).valueOf() && (o = h.computeDurationGreatestUnit(r, i), e.duration = r, e.durationUnit = o, 1 === r.as(o) && (e.singleUnit = o, u.unshift(s[o] || {}))), e.defaults = f.mergeOptions(l), e.overrides = f.mergeOptions(u), this.buildViewSpecOptions(e), this.buildViewSpecButtonText(e, t), e)
                }, t.prototype.buildViewSpecOptions = function(t) {
                    var e = this.optionsManager;
                    t.options = f.mergeOptions([f.globalDefaults, t.defaults, e.dirDefaults, e.localeDefaults, e.overrides, t.overrides, e.dynamicOverrides]), i.populateInstanceComputableOptions(t.options)
                }, t.prototype.buildViewSpecButtonText = function(n, i) {
                    var t = this.optionsManager;

                    function e(t) {
                        var e = t.buttonText || {};
                        return e[i] || (n.buttonTextKey ? e[n.buttonTextKey] : null) || (n.singleUnit ? e[n.singleUnit] : null)
                    }
                    n.buttonTextOverride = e(t.dynamicOverrides) || e(t.overrides) || n.overrides.buttonText, n.buttonTextDefault = e(t.localeDefaults) || e(t.dirDefaults) || n.defaults.buttonText || e(f.globalDefaults) || (n.duration ? this._calendar.humanizeDuration(n.duration) : null) || i
                }, t
            }();
        e.default = o
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(3),
            i = n(4),
            o = n(243),
            s = n(52),
            a = n(6),
            l = n(38),
            u = n(13),
            d = n(18),
            c = n(11),
            p = n(7),
            h = function() {
                function t(t) {
                    this.calendar = t, this.stickySource = new s.default(t), this.otherSources = []
                }
                return t.prototype.requestEvents = function(t, e, n, i) {
                    return !i && this.currentPeriod && this.currentPeriod.isWithinRange(t, e) && n === this.currentPeriod.timezone || this.setPeriod(new o.default(t, e, n)), this.currentPeriod.whenReleased()
                }, t.prototype.addSource = function(t) {
                    this.otherSources.push(t), this.currentPeriod && this.currentPeriod.requestSource(t)
                }, t.prototype.removeSource = function(t) {
                    i.removeExact(this.otherSources, t), this.currentPeriod && this.currentPeriod.purgeSource(t)
                }, t.prototype.removeAllSources = function() {
                    this.otherSources = [], this.currentPeriod && this.currentPeriod.purgeAllSources()
                }, t.prototype.refetchSource = function(t) {
                    var e = this.currentPeriod;
                    e && (e.freeze(), e.purgeSource(t), e.requestSource(t), e.thaw())
                }, t.prototype.refetchAllSources = function() {
                    var t = this.currentPeriod;
                    t && (t.freeze(), t.purgeAllSources(), t.requestSources(this.getSources()), t.thaw())
                }, t.prototype.getSources = function() {
                    return [this.stickySource].concat(this.otherSources)
                }, t.prototype.multiQuerySources = function(t) {
                    t ? r.isArray(t) || (t = [t]) : t = [];
                    var e, n = [];
                    for (e = 0; e < t.length; e++) n.push.apply(n, this.querySources(t[e]));
                    return n
                }, t.prototype.querySources = function(n) {
                    var t, e, i = this.otherSources;
                    for (t = 0; t < i.length; t++)
                        if ((e = i[t]) === n) return [e];
                    return (e = this.getSourceById(a.default.normalizeId(n))) ? [e] : (n = l.default.parse(n, this.calendar)) ? r.grep(i, function(t) {
                        return e = t, n.getPrimitive() === e.getPrimitive();
                        var e
                    }) : void 0
                }, t.prototype.getSourceById = function(e) {
                    return r.grep(this.otherSources, function(t) {
                        return t.id && t.id === e
                    })[0]
                }, t.prototype.setPeriod = function(t) {
                    this.currentPeriod && (this.unbindPeriod(this.currentPeriod), this.currentPeriod = null), this.currentPeriod = t, this.bindPeriod(t), t.requestSources(this.getSources())
                }, t.prototype.bindPeriod = function(t) {
                    this.listenTo(t, "release", function(t) {
                        this.trigger("release", t)
                    })
                }, t.prototype.unbindPeriod = function(t) {
                    this.stopListeningTo(t)
                }, t.prototype.getEventDefByUid = function(t) {
                    if (this.currentPeriod) return this.currentPeriod.getEventDefByUid(t)
                }, t.prototype.addEventDef = function(t, e) {
                    e && this.stickySource.addEventDef(t), this.currentPeriod && this.currentPeriod.addEventDef(t)
                }, t.prototype.removeEventDefsById = function(e) {
                    this.getSources().forEach(function(t) {
                        t.removeEventDefsById(e)
                    }), this.currentPeriod && this.currentPeriod.removeEventDefsById(e)
                }, t.prototype.removeAllEventDefs = function() {
                    this.getSources().forEach(function(t) {
                        t.removeAllEventDefs()
                    }), this.currentPeriod && this.currentPeriod.removeAllEventDefs()
                }, t.prototype.mutateEventsWithId = function(t, e) {
                    var n, i = this.currentPeriod,
                        r = [];
                    return i ? (i.freeze(), (n = i.getEventDefsById(t)).forEach(function(t) {
                        i.removeEventDef(t), r.push(e.mutateSingle(t)), i.addEventDef(t)
                    }), i.thaw(), function() {
                        i.freeze();
                        for (var t = 0; t < n.length; t++) i.removeEventDef(n[t]), r[t](), i.addEventDef(n[t]);
                        i.thaw()
                    }) : function() {}
                }, t.prototype.buildMutatedEventInstanceGroup = function(t, e) {
                    var n, i, r = this.getEventDefsById(t),
                        o = [];
                    for (n = 0; n < r.length; n++)(i = r[n].clone()) instanceof u.default && (e.mutateSingle(i), o.push.apply(o, i.buildInstances()));
                    return new d.default(o)
                }, t.prototype.freeze = function() {
                    this.currentPeriod && this.currentPeriod.freeze()
                }, t.prototype.thaw = function() {
                    this.currentPeriod && this.currentPeriod.thaw()
                }, t.prototype.getEventDefsById = function(t) {
                    return this.currentPeriod.getEventDefsById(t)
                }, t.prototype.getEventInstances = function() {
                    return this.currentPeriod.getEventInstances()
                }, t.prototype.getEventInstancesWithId = function(t) {
                    return this.currentPeriod.getEventInstancesWithId(t)
                }, t.prototype.getEventInstancesWithoutId = function(t) {
                    return this.currentPeriod.getEventInstancesWithoutId(t)
                }, t
            }();
        e.default = h, c.default.mixInto(h), p.default.mixInto(h)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(3),
            r = n(4),
            o = n(20),
            s = n(11),
            a = n(5),
            l = n(18),
            u = function() {
                function t(t, e, n) {
                    this.pendingCnt = 0, this.freezeDepth = 0, this.stuntedReleaseCnt = 0, this.releaseCnt = 0, this.start = t, this.end = e, this.timezone = n, this.unzonedRange = new a.default(t.clone().stripZone(), e.clone().stripZone()), this.requestsByUid = {}, this.eventDefsByUid = {}, this.eventDefsById = {}, this.eventInstanceGroupsById = {}
                }
                return t.prototype.isWithinRange = function(t, e) {
                    return !t.isBefore(this.start) && !e.isAfter(this.end)
                }, t.prototype.requestSources = function(t) {
                    this.freeze();
                    for (var e = 0; e < t.length; e++) this.requestSource(t[e]);
                    this.thaw()
                }, t.prototype.requestSource = function(t) {
                    var e = this,
                        n = {
                            source: t,
                            status: "pending",
                            eventDefs: null
                        };
                    this.requestsByUid[t.uid] = n, this.pendingCnt += 1, t.fetch(this.start, this.end, this.timezone).then(function(t) {
                        "cancelled" !== n.status && (n.status = "completed", n.eventDefs = t, e.addEventDefs(t), e.pendingCnt--, e.tryRelease())
                    }, function() {
                        "cancelled" !== n.status && (n.status = "failed", e.pendingCnt--, e.tryRelease())
                    })
                }, t.prototype.purgeSource = function(t) {
                    var e = this.requestsByUid[t.uid];
                    e && (delete this.requestsByUid[t.uid], "pending" === e.status ? (e.status = "cancelled", this.pendingCnt--, this.tryRelease()) : "completed" === e.status && e.eventDefs.forEach(this.removeEventDef.bind(this)))
                }, t.prototype.purgeAllSources = function() {
                    var t, e, n = this.requestsByUid,
                        i = 0;
                    for (t in n) "pending" === (e = n[t]).status ? e.status = "cancelled" : "completed" === e.status && i++;
                    this.requestsByUid = {}, this.pendingCnt = 0, i && this.removeAllEventDefs()
                }, t.prototype.getEventDefByUid = function(t) {
                    return this.eventDefsByUid[t]
                }, t.prototype.getEventDefsById = function(t) {
                    var e = this.eventDefsById[t];
                    return e ? e.slice() : []
                }, t.prototype.addEventDefs = function(t) {
                    for (var e = 0; e < t.length; e++) this.addEventDef(t[e])
                }, t.prototype.addEventDef = function(t) {
                    var e, n = this.eventDefsById,
                        i = t.id,
                        r = n[i] || (n[i] = []),
                        o = t.buildInstances(this.unzonedRange);
                    for (r.push(t), this.eventDefsByUid[t.uid] = t, e = 0; e < o.length; e++) this.addEventInstance(o[e], i)
                }, t.prototype.removeEventDefsById = function(t) {
                    var e = this;
                    this.getEventDefsById(t).forEach(function(t) {
                        e.removeEventDef(t)
                    })
                }, t.prototype.removeAllEventDefs = function() {
                    var t = i.isEmptyObject(this.eventDefsByUid);
                    this.eventDefsByUid = {}, this.eventDefsById = {}, this.eventInstanceGroupsById = {}, t || this.tryRelease()
                }, t.prototype.removeEventDef = function(t) {
                    var e = this.eventDefsById,
                        n = e[t.id];
                    delete this.eventDefsByUid[t.uid], n && (r.removeExact(n, t), n.length || delete e[t.id], this.removeEventInstancesForDef(t))
                }, t.prototype.getEventInstances = function() {
                    var t, e = this.eventInstanceGroupsById,
                        n = [];
                    for (t in e) n.push.apply(n, e[t].eventInstances);
                    return n
                }, t.prototype.getEventInstancesWithId = function(t) {
                    var e = this.eventInstanceGroupsById[t];
                    return e ? e.eventInstances.slice() : []
                }, t.prototype.getEventInstancesWithoutId = function(t) {
                    var e, n = this.eventInstanceGroupsById,
                        i = [];
                    for (e in n) e !== t && i.push.apply(i, n[e].eventInstances);
                    return i
                }, t.prototype.addEventInstance = function(t, e) {
                    var n = this.eventInstanceGroupsById;
                    (n[e] || (n[e] = new l.default)).eventInstances.push(t), this.tryRelease()
                }, t.prototype.removeEventInstancesForDef = function(e) {
                    var t, n = this.eventInstanceGroupsById,
                        i = n[e.id];
                    i && (t = r.removeMatching(i.eventInstances, function(t) {
                        return t.def === e
                    }), i.eventInstances.length || delete n[e.id], t && this.tryRelease())
                }, t.prototype.tryRelease = function() {
                    this.pendingCnt || (this.freezeDepth ? this.stuntedReleaseCnt++ : this.release())
                }, t.prototype.release = function() {
                    this.releaseCnt++, this.trigger("release", this.eventInstanceGroupsById)
                }, t.prototype.whenReleased = function() {
                    var e = this;
                    return this.releaseCnt ? o.default.resolve(this.eventInstanceGroupsById) : o.default.construct(function(t) {
                        e.one("release", t)
                    })
                }, t.prototype.freeze = function() {
                    this.freezeDepth++ || (this.stuntedReleaseCnt = 0)
                }, t.prototype.thaw = function() {
                    --this.freezeDepth || !this.stuntedReleaseCnt || this.pendingCnt || this.release()
                }, t
            }();
        e.default = u, s.default.mixInto(u)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var o = n(3),
            i = n(4),
            r = n(7),
            s = function() {
                function t(t, e) {
                    this.isFollowing = !1, this.isHidden = !1, this.isAnimating = !1, this.options = e = e || {}, this.sourceEl = t, this.parentEl = e.parentEl ? o(e.parentEl) : t.parent()
                }
                return t.prototype.start = function(t) {
                    this.isFollowing || (this.isFollowing = !0, this.y0 = i.getEvY(t), this.x0 = i.getEvX(t), this.topDelta = 0, this.leftDelta = 0, this.isHidden || this.updatePosition(), i.getEvIsTouch(t) ? this.listenTo(o(document), "touchmove", this.handleMove) : this.listenTo(o(document), "mousemove", this.handleMove))
                }, t.prototype.stop = function(t, e) {
                    var n = this,
                        i = this.options.revertDuration,
                        r = function() {
                            n.isAnimating = !1, n.removeElement(), n.top0 = n.left0 = null, e && e()
                        };
                    this.isFollowing && !this.isAnimating && (this.isFollowing = !1, this.stopListeningTo(o(document)), t && i && !this.isHidden ? (this.isAnimating = !0, this.el.animate({
                        top: this.top0,
                        left: this.left0
                    }, {
                        duration: i,
                        complete: r
                    })) : r())
                }, t.prototype.getEl = function() {
                    var t = this.el;
                    return t || ((t = this.el = this.sourceEl.clone().addClass(this.options.additionalClass || "").css({
                        position: "absolute",
                        visibility: "",
                        display: this.isHidden ? "none" : "",
                        margin: 0,
                        right: "auto",
                        bottom: "auto",
                        width: this.sourceEl.width(),
                        height: this.sourceEl.height(),
                        opacity: this.options.opacity || "",
                        zIndex: this.options.zIndex
                    })).addClass("fc-unselectable"), t.appendTo(this.parentEl)), t
                }, t.prototype.removeElement = function() {
                    this.el && (this.el.remove(), this.el = null)
                }, t.prototype.updatePosition = function() {
                    var t, e;
                    this.getEl(), null == this.top0 && (t = this.sourceEl.offset(), e = this.el.offsetParent().offset(), this.top0 = t.top - e.top, this.left0 = t.left - e.left), this.el.css({
                        top: this.top0 + this.topDelta,
                        left: this.left0 + this.leftDelta
                    })
                }, t.prototype.handleMove = function(t) {
                    this.topDelta = i.getEvY(t) - this.y0, this.leftDelta = i.getEvX(t) - this.x0, this.isHidden || this.updatePosition()
                }, t.prototype.hide = function() {
                    this.isHidden || (this.isHidden = !0, this.el && this.el.hide())
                }, t.prototype.show = function() {
                    this.isHidden && (this.isHidden = !1, this.updatePosition(), this.getEl().show())
                }, t
            }();
        e.default = s, r.default.mixInto(s)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            s = n(23),
            r = function(n) {
                function t(t) {
                    var e = n.call(this, t) || this;
                    return e.dragListener = e.buildDragListener(), e
                }
                return i.__extends(t, n), t.prototype.end = function() {
                    this.dragListener.endInteraction()
                }, t.prototype.bindToEl = function(t) {
                    var e = this.component,
                        n = this.dragListener;
                    e.bindDateHandlerToEl(t, "mousedown", function(t) {
                        e.shouldIgnoreMouse() || n.startInteraction(t)
                    }), e.bindDateHandlerToEl(t, "touchstart", function(t) {
                        e.shouldIgnoreTouch() || n.startInteraction(t)
                    })
                }, t.prototype.buildDragListener = function() {
                    var i, r = this,
                        o = this.component,
                        t = new s.default(o, {
                            scroll: this.opt("dragScroll"),
                            interactionStart: function() {
                                i = t.origHit
                            },
                            hitOver: function(t, e, n) {
                                e || (i = null)
                            },
                            hitOut: function() {
                                i = null
                            },
                            interactionEnd: function(t, e) {
                                var n;
                                !e && i && (n = o.getSafeHitFootprint(i)) && r.view.triggerDayClick(n, o.getHitEl(i), t)
                            }
                        });
                    return t.shouldCancelTouchScroll = !1, t.scrollAlwaysKills = !0, t
                }, t
            }(n(15).default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            y = n(4),
            i = function(i) {
                function t(t, e) {
                    var n = i.call(this, t, e) || this;
                    return n.timeGrid = t, n
                }
                return r.__extends(t, i), t.prototype.renderFgSegs = function(t) {
                    this.renderFgSegsIntoContainers(t, this.timeGrid.fgContainerEls)
                }, t.prototype.renderFgSegsIntoContainers = function(t, e) {
                    var n, i;
                    for (n = this.timeGrid.groupSegsByCol(t), i = 0; i < this.timeGrid.colCnt; i++) this.updateFgSegCoords(n[i]);
                    this.timeGrid.attachSegsByCol(n, e)
                }, t.prototype.unrenderFgSegs = function() {
                    this.fgSegs && this.fgSegs.forEach(function(t) {
                        t.el.remove()
                    })
                }, t.prototype.computeEventTimeFormat = function() {
                    return this.opt("noMeridiemTimeFormat")
                }, t.prototype.computeDisplayEventEnd = function() {
                    return !0
                }, t.prototype.fgSegHtml = function(t, e) {
                    var n, i, r, o = this.view,
                        s = o.calendar,
                        a = t.footprint.componentFootprint,
                        l = a.isAllDay,
                        u = t.footprint.eventDef,
                        d = o.isEventDefDraggable(u),
                        c = !e && t.isStart && o.isEventDefResizableFromStart(u),
                        p = !e && t.isEnd && o.isEventDefResizableFromEnd(u),
                        h = this.getSegClasses(t, d, c || p),
                        f = y.cssToStr(this.getSkinCss(u));
                    if (h.unshift("fc-time-grid-event", "fc-v-event"), o.isMultiDayRange(a.unzonedRange)) {
                        if (t.isStart || t.isEnd) {
                            var g = s.msToMoment(t.startMs),
                                v = s.msToMoment(t.endMs);
                            n = this._getTimeText(g, v, l), i = this._getTimeText(g, v, l, "LT"), r = this._getTimeText(g, v, l, null, !1)
                        }
                    } else n = this.getTimeText(t.footprint), i = this.getTimeText(t.footprint, "LT"), r = this.getTimeText(t.footprint, null, !1);
                    return '<a class="' + h.join(" ") + '"' + (u.url ? ' href="' + y.htmlEscape(u.url) + '"' : "") + (f ? ' style="' + f + '"' : "") + '><div class="fc-content">' + (n ? '<div class="fc-time" data-start="' + y.htmlEscape(r) + '" data-full="' + y.htmlEscape(i) + '"><span>' + y.htmlEscape(n) + "</span></div>" : "") + (u.title ? '<div class="fc-title">' + y.htmlEscape(u.title) + "</div>" : "") + '</div><div class="fc-bg"/>' + (p ? '<div class="fc-resizer fc-end-resizer" />' : "") + "</a>"
                }, t.prototype.updateFgSegCoords = function(t) {
                    this.timeGrid.computeSegVerticals(t), this.computeFgSegHorizontals(t), this.timeGrid.assignSegVerticals(t), this.assignFgSegHorizontals(t)
                }, t.prototype.computeFgSegHorizontals = function(t) {
                    var e, n, i;
                    if (this.sortEventSegs(t), function(t) {
                            var e, n, i, r, o;
                            for (e = 0; e < t.length; e++)
                                for (n = t[e], i = 0; i < n.length; i++)
                                    for ((r = n[i]).forwardSegs = [], o = e + 1; o < t.length; o++) s(r, t[o], r.forwardSegs)
                        }(e = function(t) {
                            var e, n, i, r = [];
                            for (e = 0; e < t.length; e++) {
                                for (n = t[e], i = 0; i < r.length && s(n, r[i]).length; i++);
                                n.level = i, (r[i] || (r[i] = [])).push(n)
                            }
                            return r
                        }(t)), n = e[0]) {
                        for (i = 0; i < n.length; i++) o(n[i]);
                        for (i = 0; i < n.length; i++) this.computeFgSegForwardBack(n[i], 0, 0)
                    }
                }, t.prototype.computeFgSegForwardBack = function(t, e, n) {
                    var i, r = t.forwardSegs;
                    if (void 0 === t.forwardCoord)
                        for (r.length ? (this.sortForwardSegs(r), this.computeFgSegForwardBack(r[0], e + 1, n), t.forwardCoord = r[0].backwardCoord) : t.forwardCoord = 1, t.backwardCoord = t.forwardCoord - (t.forwardCoord - n) / (e + 1), i = 0; i < r.length; i++) this.computeFgSegForwardBack(r[i], 0, t.forwardCoord)
                }, t.prototype.sortForwardSegs = function(t) {
                    t.sort(y.proxy(this, "compareForwardSegs"))
                }, t.prototype.compareForwardSegs = function(t, e) {
                    return e.forwardPressure - t.forwardPressure || (t.backwardCoord || 0) - (e.backwardCoord || 0) || this.compareEventSegs(t, e)
                }, t.prototype.assignFgSegHorizontals = function(t) {
                    var e, n;
                    for (e = 0; e < t.length; e++)(n = t[e]).el.css(this.generateFgSegHorizontalCss(n)), n.bottom - n.top < 30 && n.el.addClass("fc-short")
                }, t.prototype.generateFgSegHorizontalCss = function(t) {
                    var e, n, i = this.opt("slotEventOverlap"),
                        r = t.backwardCoord,
                        o = t.forwardCoord,
                        s = this.timeGrid.generateSegVerticalCss(t),
                        a = this.timeGrid.isRTL;
                    return i && (o = Math.min(1, r + 2 * (o - r))), a ? (e = 1 - o, n = r) : (e = r, n = 1 - o), s.zIndex = t.level + 1, s.left = 100 * e + "%", s.right = 100 * n + "%", i && t.forwardPressure && (s[a ? "marginLeft" : "marginRight"] = 20), s
                }, t
            }(n(42).default);

        function o(t) {
            var e, n, i = t.forwardSegs,
                r = 0;
            if (void 0 === t.forwardPressure) {
                for (e = 0; e < i.length; e++) o(n = i[e]), r = Math.max(r, 1 + n.forwardPressure);
                t.forwardPressure = r
            }
        }

        function s(t, e, n) {
            void 0 === n && (n = []);
            for (var i = 0; i < e.length; i++) r = t, o = e[i], r.bottom > o.top && r.top < o.bottom && n.push(e[i]);
            var r, o;
            return n
        }
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            s = n(3),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.renderSegs = function(t, e) {
                    var n, i, r, o = [];
                    for (this.eventRenderer.renderFgSegsIntoContainers(t, this.component.helperContainerEls), n = 0; n < t.length; n++) i = t[n], e && e.col === i.col && (r = e.el, i.el.css({
                        left: r.css("left"),
                        right: r.css("right"),
                        "margin-left": r.css("margin-left"),
                        "margin-right": r.css("margin-right")
                    })), o.push(i.el[0]);
                    return s(o)
                }, e
            }(n(58).default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.attachSegEls = function(t, e) {
                    var n, i = this.component;
                    return "bgEvent" === t ? n = i.bgContainerEls : "businessHours" === t ? n = i.businessContainerEls : "highlight" === t && (n = i.highlightContainerEls), i.updateSegVerticals(e), i.attachSegsByCol(i.groupSegsByCol(e), n), e.map(function(t) {
                        return t.el[0]
                    })
                }, e
            }(n(57).default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var c = n(3),
            p = n(4),
            i = n(7),
            r = function() {
                function t(t) {
                    this.isHidden = !0, this.margin = 10, this.options = t || {}
                }
                return t.prototype.show = function() {
                    this.isHidden && (this.el || this.render(), this.el.show(), this.position(), this.isHidden = !1, this.trigger("show"))
                }, t.prototype.hide = function() {
                    this.isHidden || (this.el.hide(), this.isHidden = !0, this.trigger("hide"))
                }, t.prototype.render = function() {
                    var t = this,
                        e = this.options;
                    this.el = c('<div class="fc-popover"/>').addClass(e.className || "").css({
                        top: 0,
                        left: 0
                    }).append(e.content).appendTo(e.parentEl), this.el.on("click", ".fc-close", function() {
                        t.hide()
                    }), e.autoHide && this.listenTo(c(document), "mousedown", this.documentMousedown)
                }, t.prototype.documentMousedown = function(t) {
                    this.el && !c(t.target).closest(this.el).length && this.hide()
                }, t.prototype.removeElement = function() {
                    this.hide(), this.el && (this.el.remove(), this.el = null), this.stopListeningTo(c(document), "mousedown")
                }, t.prototype.position = function() {
                    var t, e, n, i, r, o = this.options,
                        s = this.el.offsetParent().offset(),
                        a = this.el.outerWidth(),
                        l = this.el.outerHeight(),
                        u = c(window),
                        d = p.getScrollParent(this.el);
                    i = o.top || 0, r = void 0 !== o.left ? o.left : void 0 !== o.right ? o.right - a : 0, d.is(window) || d.is(document) ? (d = u, e = t = 0) : (t = (n = d.offset()).top, e = n.left), t += u.scrollTop(), e += u.scrollLeft(), !1 !== o.viewportConstrain && (i = Math.min(i, t + d.outerHeight() - l - this.margin), i = Math.max(i, t + this.margin), r = Math.min(r, e + d.outerWidth() - a - this.margin), r = Math.max(r, e + this.margin)), this.el.css({
                        top: i - s.top,
                        left: r - s.left
                    })
                }, t.prototype.trigger = function(t) {
                    this.options[t] && this.options[t].apply(this, Array.prototype.slice.call(arguments, 1))
                }, t
            }();
        e.default = r, i.default.mixInto(r)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            y = n(3),
            h = n(4),
            i = function(i) {
                function t(t, e) {
                    var n = i.call(this, t, e) || this;
                    return n.dayGrid = t, n
                }
                return r.__extends(t, i), t.prototype.renderBgRanges = function(t) {
                    t = y.grep(t, function(t) {
                        return t.eventDef.isAllDay()
                    }), i.prototype.renderBgRanges.call(this, t)
                }, t.prototype.renderFgSegs = function(t) {
                    var n = this.rowStructs = this.renderSegRows(t);
                    this.dayGrid.rowEls.each(function(t, e) {
                        y(e).find(".fc-content-skeleton > table").append(n[t].tbodyEl)
                    })
                }, t.prototype.unrenderFgSegs = function() {
                    for (var t, e = this.rowStructs || []; t = e.pop();) t.tbodyEl.remove();
                    this.rowStructs = null
                }, t.prototype.renderSegRows = function(t) {
                    var e, n, i = [];
                    for (e = this.groupSegRows(t), n = 0; n < e.length; n++) i.push(this.renderSegRow(n, e[n]));
                    return i
                }, t.prototype.renderSegRow = function(t, e) {
                    var n, i, r, o, s, a, l, u = this.dayGrid.colCnt,
                        d = this.buildSegLevels(e),
                        c = Math.max(1, d.length),
                        p = y("<tbody/>"),
                        h = [],
                        f = [],
                        g = [];

                    function v(t) {
                        for (; r < t;)(l = (g[n - 1] || [])[r]) ? l.attr("rowspan", parseInt(l.attr("rowspan") || 1, 10) + 1) : (l = y("<td/>"), o.append(l)), f[n][r] = l, g[n][r] = l, r++
                    }
                    for (n = 0; n < c; n++) {
                        if (i = d[n], r = 0, o = y("<tr/>"), h.push([]), f.push([]), g.push([]), i)
                            for (s = 0; s < i.length; s++) {
                                for (v((a = i[s]).leftCol), l = y('<td class="fc-event-container"/>').append(a.el), a.leftCol !== a.rightCol ? l.attr("colspan", a.rightCol - a.leftCol + 1) : g[n][r] = l; r <= a.rightCol;) f[n][r] = l, h[n][r] = a, r++;
                                o.append(l)
                            }
                        v(u), this.dayGrid.bookendCells(o), p.append(o)
                    }
                    return {
                        row: t,
                        tbodyEl: p,
                        cellMatrix: f,
                        segMatrix: h,
                        segLevels: d,
                        segs: e
                    }
                }, t.prototype.buildSegLevels = function(t) {
                    var e, n, i, r = [];
                    for (this.sortEventSegs(t), e = 0; e < t.length; e++) {
                        for (n = t[e], i = 0; i < r.length && o(n, r[i]); i++);
                        (r[n.level = i] || (r[i] = [])).push(n)
                    }
                    for (i = 0; i < r.length; i++) r[i].sort(s);
                    return r
                }, t.prototype.groupSegRows = function(t) {
                    var e, n = [];
                    for (e = 0; e < this.dayGrid.rowCnt; e++) n.push([]);
                    for (e = 0; e < t.length; e++) n[t[e].row].push(t[e]);
                    return n
                }, t.prototype.computeEventTimeFormat = function() {
                    return this.opt("extraSmallTimeFormat")
                }, t.prototype.computeDisplayEventEnd = function() {
                    return 1 === this.dayGrid.colCnt
                }, t.prototype.fgSegHtml = function(t, e) {
                    var n, i, r = this.view,
                        o = t.footprint.eventDef,
                        s = t.footprint.componentFootprint.isAllDay,
                        a = r.isEventDefDraggable(o),
                        l = !e && s && t.isStart && r.isEventDefResizableFromStart(o),
                        u = !e && s && t.isEnd && r.isEventDefResizableFromEnd(o),
                        d = this.getSegClasses(t, a, l || u),
                        c = h.cssToStr(this.getSkinCss(o)),
                        p = "";
                    return d.unshift("fc-day-grid-event", "fc-h-event"), t.isStart && (n = this.getTimeText(t.footprint)) && (p = '<span class="fc-time">' + h.htmlEscape(n) + "</span>"), i = '<span class="fc-title">' + (h.htmlEscape(o.title || "") || "&nbsp;") + "</span>", '<a class="' + d.join(" ") + '"' + (o.url ? ' href="' + h.htmlEscape(o.url) + '"' : "") + (c ? ' style="' + c + '"' : "") + '><div class="fc-content">' + (this.dayGrid.isRTL ? i + " " + p : p + " " + i) + "</div>" + (l ? '<div class="fc-resizer fc-start-resizer" />' : "") + (u ? '<div class="fc-resizer fc-end-resizer" />' : "") + "</a>"
                }, t
            }(n(42).default);

        function o(t, e) {
            var n, i;
            for (n = 0; n < e.length; n++)
                if ((i = e[n]).leftCol <= t.rightCol && i.rightCol >= t.leftCol) return !0;
            return !1
        }

        function s(t, e) {
            return t.leftCol - e.leftCol
        }
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            u = n(3),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.renderSegs = function(t, s) {
                    var a, l = [];
                    return a = this.eventRenderer.renderSegRows(t), this.component.rowEls.each(function(t, e) {
                        var n, i, r = u(e),
                            o = u('<div class="fc-helper-skeleton"><table/></div>');
                        s && s.row === t ? i = s.el.position().top : ((n = r.find(".fc-content-skeleton tbody")).length || (n = r.find(".fc-content-skeleton table")), i = n.position().top), o.css("top", i).find("table").append(a[t].tbodyEl), r.append(o), l.push(o[0])
                    }), u(l)
                }, e
            }(n(58).default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            l = n(3),
            r = function(e) {
                function t() {
                    var t = null !== e && e.apply(this, arguments) || this;
                    return t.fillSegTag = "td", t
                }
                return i.__extends(t, e), t.prototype.attachSegEls = function(t, e) {
                    var n, i, r, o = [];
                    for (n = 0; n < e.length; n++) i = e[n], r = this.renderFillRow(t, i), this.component.rowEls.eq(i.row).append(r), o.push(r[0]);
                    return o
                }, t.prototype.renderFillRow = function(t, e) {
                    var n, i, r, o = this.component.colCnt,
                        s = e.leftCol,
                        a = e.rightCol + 1;
                    return n = "businessHours" === t ? "bgevent" : t.toLowerCase(), r = (i = l('<div class="fc-' + n + '-skeleton"><table><tr/></table></div>')).find("tr"), 0 < s && r.append('<td colspan="' + s + '"/>'), r.append(e.el.attr("colspan", a - s)), a < o && r.append('<td colspan="' + (o - a) + '"/>'), this.component.bookendCells(r), i
                }, t
            }(n(57).default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = n(228),
            l = n(5),
            o = function(a) {
                function t() {
                    return null !== a && a.apply(this, arguments) || this
                }
                return i.__extends(t, a), t.prototype.buildRenderRange = function(t, e, n) {
                    var i, r = a.prototype.buildRenderRange.call(this, t, e, n),
                        o = this.msToUtcMoment(r.startMs, n),
                        s = this.msToUtcMoment(r.endMs, n);
                    return this.opt("fixedWeekCount") && (i = Math.ceil(s.diff(o, "weeks", !0)), s.add(6 - i, "weeks")), new l.default(o, s)
                }, t
            }(r.default);
        e.default = o
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            c = n(4),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e.prototype.renderFgSegs = function(t) {
                    t.length ? this.component.renderSegList(t) : this.component.renderEmptyMessage()
                }, e.prototype.fgSegHtml = function(t) {
                    var e, n = this.view,
                        i = n.calendar,
                        r = i.theme,
                        o = t.footprint,
                        s = o.eventDef,
                        a = o.componentFootprint,
                        l = s.url,
                        u = ["fc-list-item"].concat(this.getClasses(s)),
                        d = this.getBgColor(s);
                    return e = a.isAllDay ? n.getAllDayHtml() : n.isMultiDayRange(a.unzonedRange) ? t.isStart || t.isEnd ? c.htmlEscape(this._getTimeText(i.msToMoment(t.startMs), i.msToMoment(t.endMs), a.isAllDay)) : n.getAllDayHtml() : c.htmlEscape(this.getTimeText(o)), l && u.push("fc-has-url"), '<tr class="' + u.join(" ") + '">' + (this.displayEventTime ? '<td class="fc-list-item-time ' + r.getClass("widgetContent") + '">' + (e || "") + "</td>" : "") + '<td class="fc-list-item-marker ' + r.getClass("widgetContent") + '"><span class="fc-event-dot"' + (d ? ' style="background-color:' + d + '"' : "") + '></span></td><td class="fc-list-item-title ' + r.getClass("widgetContent") + '"><a' + (l ? ' href="' + c.htmlEscape(l) + '"' : "") + ">" + c.htmlEscape(s.title || "") + "</a></td></tr>"
                }, e.prototype.computeEventTimeFormat = function() {
                    return this.opt("mediumTimeFormat")
                }, e
            }(n(42).default);
        e.default = r
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var r = n(2),
            o = n(3),
            i = function(i) {
                function t() {
                    return null !== i && i.apply(this, arguments) || this
                }
                return r.__extends(t, i), t.prototype.handleClick = function(t, e) {
                    var n;
                    i.prototype.handleClick.call(this, t, e), o(e.target).closest("a[href]").length || (n = t.footprint.eventDef.url) && !e.isDefaultPrevented() && (window.location.href = n)
                }, t
            }(n(59).default);
        e.default = i
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(38),
            r = n(52),
            o = n(215),
            s = n(216);
        i.default.registerClass(r.default), i.default.registerClass(o.default), i.default.registerClass(s.default)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(51),
            r = n(213),
            o = n(214),
            s = n(258),
            a = n(259);
        i.defineThemeSystem("standard", r.default), i.defineThemeSystem("jquery-ui", o.default), i.defineThemeSystem("bootstrap3", s.default), i.defineThemeSystem("bootstrap4", a.default)
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e
            }(n(19).default);
        (e.default = r).prototype.classes = {
            widget: "fc-bootstrap3",
            tableGrid: "table-bordered",
            tableList: "table",
            tableListHeading: "active",
            buttonGroup: "btn-group",
            button: "btn btn-default",
            stateActive: "active",
            stateDisabled: "disabled",
            today: "alert alert-info",
            popover: "panel panel-default",
            popoverHeader: "panel-heading",
            popoverContent: "panel-body",
            headerRow: "panel-default",
            dayRow: "panel-default",
            listView: "panel panel-default"
        }, r.prototype.baseIconClass = "glyphicon", r.prototype.iconClasses = {
            close: "glyphicon-remove",
            prev: "glyphicon-chevron-left",
            next: "glyphicon-chevron-right",
            prevYear: "glyphicon-backward",
            nextYear: "glyphicon-forward"
        }, r.prototype.iconOverrideOption = "bootstrapGlyphicons", r.prototype.iconOverrideCustomButtonOption = "bootstrapGlyphicon", r.prototype.iconOverridePrefix = "glyphicon-"
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(2),
            r = function(t) {
                function e() {
                    return null !== t && t.apply(this, arguments) || this
                }
                return i.__extends(e, t), e
            }(n(19).default);
        (e.default = r).prototype.classes = {
            widget: "fc-bootstrap4",
            tableGrid: "table-bordered",
            tableList: "table",
            tableListHeading: "table-active",
            buttonGroup: "btn-group",
            button: "btn btn-primary",
            stateActive: "active",
            stateDisabled: "disabled",
            today: "alert alert-info",
            popover: "card card-primary",
            popoverHeader: "card-header",
            popoverContent: "card-body",
            headerRow: "table-bordered",
            dayRow: "table-bordered",
            listView: "card card-primary"
        }, r.prototype.baseIconClass = "fa", r.prototype.iconClasses = {
            close: "fa-times",
            prev: "fa-chevron-left",
            next: "fa-chevron-right",
            prevYear: "fa-angle-double-left",
            nextYear: "fa-angle-double-right"
        }, r.prototype.iconOverrideOption = "bootstrapFontAwesome", r.prototype.iconOverrideCustomButtonOption = "bootstrapFontAwesome", r.prototype.iconOverridePrefix = "fa-"
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(22),
            r = n(62),
            o = n(229);
        i.defineView("basic", {
            class: r.default
        }), i.defineView("basicDay", {
            type: "basic",
            duration: {
                days: 1
            }
        }), i.defineView("basicWeek", {
            type: "basic",
            duration: {
                weeks: 1
            }
        }), i.defineView("month", {
            class: o.default,
            duration: {
                months: 1
            },
            defaults: {
                fixedWeekCount: !0
            }
        })
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(22),
            r = n(226);
        i.defineView("agenda", {
            class: r.default,
            defaults: {
                allDaySlot: !0,
                slotDuration: "00:30:00",
                slotEventOverlap: !0
            }
        }), i.defineView("agendaDay", {
            type: "agenda",
            duration: {
                days: 1
            }
        }), i.defineView("agendaWeek", {
            type: "agenda",
            duration: {
                weeks: 1
            }
        })
    }, function(t, e, n) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        });
        var i = n(22),
            r = n(230);
        i.defineView("list", {
            class: r.default,
            buttonTextKey: "list",
            defaults: {
                buttonText: "list",
                listDayFormat: "LL",
                noEventsMessage: "No events to display"
            }
        }), i.defineView("listDay", {
            type: "list",
            duration: {
                days: 1
            },
            defaults: {
                listDayFormat: "dddd"
            }
        }), i.defineView("listWeek", {
            type: "list",
            duration: {
                weeks: 1
            },
            defaults: {
                listDayFormat: "dddd",
                listDayAltFormat: "LL"
            }
        }), i.defineView("listMonth", {
            type: "list",
            duration: {
                month: 1
            },
            defaults: {
                listDayAltFormat: "dddd"
            }
        }), i.defineView("listYear", {
            type: "list",
            duration: {
                year: 1
            },
            defaults: {
                listDayAltFormat: "dddd"
            }
        })
    }, function(t, e) {
        Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }])
});