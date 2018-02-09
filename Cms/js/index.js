import React, {Component} from 'react';
import ReactDOM from 'react-dom';

import {
    BrowserRouter,
    Link,
    Route,
    Switch
} from 'react-router-dom';

import Home from './components/Home.react';
import Post from './components/Post.react';
import Tag from './components/Tag.react';

class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <div>
                    <header>
                        <nav>
                            <ul>
                                <li>
                                    <Link to="/">Home</Link>
                                </li>
                                <li>
                                    <Link to="/post">Post</Link>
                                </li>
                                <li>
                                    <Link to="/tag">Tag</Link>
                                </li>
                            </ul>
                        </nav>
                    </header>
                    <main>
                        <Switch>
                            <Route exact path='/' component={Home}/>
                            <Route exact path='/post' component={Post}/>
                            <Route exact path='/tag' component={Tag}/>
                        </Switch>
                    </main>
                </div>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('app'));