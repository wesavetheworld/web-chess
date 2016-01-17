System.register(['angular2/core', '../expandable-search/expandable-search', '../tabs/tabs'], function(exports_1) {
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var core_1, expandable_search_1, tabs_1;
    var AppComponent;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (expandable_search_1_1) {
                expandable_search_1 = expandable_search_1_1;
            },
            function (tabs_1_1) {
                tabs_1 = tabs_1_1;
            }],
        execute: function() {
            AppComponent = (function () {
                function AppComponent() {
                    this.tabList = [
                        {
                            "name": "Tab 1",
                            "content": "<h1>Hello</h1>"
                        },
                        {
                            "name": "Tab 2",
                            "content": "<h1>World</h1>"
                        },
                        {
                            "name": "Tab 3",
                            "content": "<h1>!</h1>"
                        }
                    ];
                }
                AppComponent = __decorate([
                    core_1.Component({
                        selector: 'web-chess',
                        templateUrl: 'js/components/app/app.html',
                        directives: [
                            expandable_search_1.ExpandableSearchComponent,
                            tabs_1.TabsComponent
                        ]
                    }), 
                    __metadata('design:paramtypes', [])
                ], AppComponent);
                return AppComponent;
            })();
            exports_1("AppComponent", AppComponent);
        }
    }
});

//# sourceMappingURL=app.js.map
