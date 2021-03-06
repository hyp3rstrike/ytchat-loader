# YouTube Chat Loader v2.0
This project was created to provide YouTube Live Broadcasters a way to easily load their chat window, without any third party plugins or software. It's lightweight, and primarily uses PHP to authenticate with Google, read the API to fetch the unique ID, and load it all in the same browser window.

# Why?
Much in the same way that regular uploads on YouTube behave, LiveBroadcasts are also assigned a unique ID string when created. Subsequently, the live chat log for that stream is also assigned that unique ID string, which means that bookmarking the URL or adding it in as a browser dock to OBS Studio is useless, because the ID will change the next time you stream.

There are other working solutions like the OBS Studio fork by Streamlabs (called Streamlabs OBS), or OBS.live by Stream Elements. While both of these solutions "work", I've found SLOBS to a bloated piece of shit with unacceptable performance trade-offs, and I'm not a fan of the OBS.live plugin because it essentially means you need to use Stream Elements.

What I've set out to create is an plugin or service independent, lightweight script that fetches and loads your next stream ID string, and loads the chat in whatever you choose to use it in.

# How is it different?
There are a couple of advatanges to the script I've made.
- It is lightweight, and uses next to no resources (outside of what is needed to load the content)
- You can use it in an OBS Studio Browser dock, or as a standalone browser window. No third party plugins or services required.
- Unlike the SLOBS or OBS.live solutions, your chat window isn't in read-only mode, meaning you can interact with your viewers via the chat directly.
- It can be forked and run on a private hosting account or virtual private server, or run locally via something like XAMPP.

# Usage
If you're not too savvy and just want to use what I've created, you can use it from [my website](https://ytchat.hyp3r.tv/). I'm assuming you know how to bookmark or create a browser dock in OBS Studio.

# Self-hosting (advanced usage)
If you prefer to self host it, you can download it from the releases or fork it.

You will need to create an API Key and Client ID in your own project via the [Google Developer Console](https://console.developers.google.com). The API you'll need access to is the YouTube Data V3. The rest is pretty much "read and fill".

# Support
This project shouldn't need a great deal of support, if at all. But if you have a problem, and you've followed the golden rule of RTFM, then lodge an issue.