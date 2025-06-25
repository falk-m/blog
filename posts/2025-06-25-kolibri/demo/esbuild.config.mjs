import * as esbuild from 'esbuild'

const config = (isProduction) => { return {
  entryPoints: ['src/app.js'],
    bundle: true,
    minify: !!isProduction,
    outdir: 'dist',
}};

if(process.argv.indexOf("--watch") >= 0){
  let ctx = await esbuild.context(config(false))
  
  await ctx.watch()
}
else {
  await esbuild.build(config(true))
}

