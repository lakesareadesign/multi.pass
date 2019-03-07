# Ultimate Branding

## Branches
- `development`: Use this branch to develop things & rebrand to Branda!
- `master`: Merge `development` into this one when a new version is ready

## Redesign

`development` This is a branch for Branda (not Ultimate Branding) re-design.

Asana:

https://app.asana.com/0/47431170559378/744554987354381

invision:
https://projects.invisionapp.com/d/main#/projects/prototypes/15043732

Trello:

https://trello.com/c/aErXNGah/201-branda-sui2-update-wporg-version

#### Installing dependencies and initial configuration for development (former v3)

Install Node, if not already installed
```
# curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
# sudo apt-get install -y nodejs build-essential
```

Install the necessary npm modules and packages
```
# npm install
``` 

**IMPORTANT!** After branch checkout and installing/updating dependencies, you need to run `npm run compile` in order to build the assets
(minified versions of css and js files). Precompiled assets are not included with the development version of the plugin.
This is done so that the git commits are clean and do not include the built assets that are regenerated with every
change in the css/js files.

### Build tasks (npm)

Command | Action
------- | ------
`npm run watch` | Start watching JS files
`npm run compile` | Compile assets
`npm run translate` | Build pot file inside /languages/ folder
`npm run build` | Build release copy

