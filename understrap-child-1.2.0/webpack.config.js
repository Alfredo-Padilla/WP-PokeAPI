const path = require('path');
const defaults = require('@wordpress/scripts/config/webpack.config');

module.exports = {
    ...defaults,
    entry: {
        scripts: path.resolve(process.cwd(), 'src', 'scripts.ts'),
    },
    output: {
        filename: '[name].js',
        path: path.resolve(process.cwd(), 'public'),
    },   
    module: {
        ...defaults.module,
        rules: [
            ...defaults.module.rules,
            {
                test: /\.tsx?$/,
                use: [
                    {
                        loader: 'ts-loader',
                        options: {
                            configFile: path.resolve(process.cwd(), 'tsconfig.json'),
                            transpileOnly: true,
                        },
                    }
                ],
            },
        ],
    },
    resolve: {
        extensions: [ '.ts', '.tsx', ...(defaults.resolve ?  defaults.resolve.extensions || ['.js', '.jsx'] : []) ],
    },
};