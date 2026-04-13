<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Iventaris-App — SMK Wikrama Bogor</title>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Orbitron:wght@400;500;600;700;800;900&family=DM+Mono:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}

:root{
  --void:#020a0f;
  --deep:#050f17;
  --panel:#071825;
  --surface:#0a2030;
  --border:rgba(0,210,255,0.12);
  --border-bright:rgba(0,210,255,0.35);
  --cyan:#00d2ff;
  --cyan-dim:rgba(0,210,255,0.6);
  --cyan-glow:rgba(0,210,255,0.15);
  --amber:#ff9500;
  --amber-dim:rgba(255,149,0,0.65);
  --green:#00ff9d;
  --green-dim:rgba(0,255,157,0.6);
  --text:#c8e8f0;
  --text-dim:rgba(140,190,210,0.6);
  --text-muted:rgba(100,150,170,0.4);
  --font-hud:'Orbitron',monospace;
  --font-body:'Space Grotesk',sans-serif;
  --font-mono:'DM Mono',monospace;
  --r:6px;
}

html{scroll-behavior:smooth;}

body{
  font-family:var(--font-body);
  background:var(--void);
  color:var(--text);
  overflow-x:hidden;
  cursor:none;
}

/* ── CUSTOM CURSOR ── */
.cursor{
  position:fixed;width:12px;height:12px;
  background:var(--cyan);border-radius:50%;
  pointer-events:none;z-index:9999;
  transform:translate(-50%,-50%);
  transition:transform 0.1s,width 0.2s,height 0.2s,opacity 0.2s;
  mix-blend-mode:screen;
}
.cursor-ring{
  position:fixed;width:36px;height:36px;
  border:1px solid rgba(0,210,255,0.5);border-radius:50%;
  pointer-events:none;z-index:9998;
  transform:translate(-50%,-50%);
  transition:transform 0.15s ease,width 0.3s,height 0.3s;
}
body:hover .cursor{opacity:1;}

/* ── GRID BACKGROUND ── */
.grid-bg{
  position:fixed;inset:0;z-index:0;pointer-events:none;
  background-image:
    linear-gradient(rgba(0,210,255,0.03) 1px,transparent 1px),
    linear-gradient(90deg,rgba(0,210,255,0.03) 1px,transparent 1px);
  background-size:60px 60px;
  mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,black 30%,transparent 100%);
}

/* ── AMBIENT ORBS ── */
.orb{position:fixed;border-radius:50%;pointer-events:none;z-index:0;filter:blur(80px);}
.orb-1{width:500px;height:500px;background:rgba(0,210,255,0.06);top:-200px;left:-100px;animation:orb-drift 18s ease-in-out infinite alternate;}
.orb-2{width:400px;height:400px;background:rgba(255,149,0,0.05);bottom:-100px;right:-100px;animation:orb-drift 22s ease-in-out infinite alternate-reverse;}
.orb-3{width:300px;height:300px;background:rgba(0,255,157,0.04);top:50%;left:60%;animation:orb-drift 16s ease-in-out infinite alternate;}

@keyframes orb-drift{
  0%{transform:translate(0,0);}
  100%{transform:translate(40px,30px);}
}

/* ── SCAN LINE ── */
.scanline{
  position:fixed;top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,transparent,rgba(0,210,255,0.4),transparent);
  z-index:1;pointer-events:none;
  animation:scan 6s linear infinite;
}
@keyframes scan{
  0%{top:-2px;opacity:0;}
  5%{opacity:1;}
  95%{opacity:0.3;}
  100%{top:100vh;opacity:0;}
}

/* ── NAV ── */
nav{
  position:fixed;top:0;left:0;right:0;z-index:100;
  height:64px;
  display:flex;align-items:center;justify-content:space-between;
  padding:0 3%;
  background:rgba(2,10,15,0.75);
  backdrop-filter:blur(20px);
  border-bottom:1px solid var(--border);
}

.nav-logo{
  display:flex;align-items:center;gap:14px;
  text-decoration:none;
}

/* IMAGE PLACEHOLDER — top-left */
.logo-img-wrap{
  width:42px;height:42px;border-radius:8px;
  border:1px solid var(--border-bright);
  overflow:hidden;position:relative;
  background:var(--surface);
  display:flex;align-items:center;justify-content:center;
  flex-shrink:0;
}
.logo-img-wrap img{width:100%;height:100%;object-fit:cover;display:block;}
.logo-img-placeholder{
  font-family:var(--font-hud);font-size:9px;
  color:var(--cyan-dim);text-align:center;line-height:1.3;
  padding:4px;
}
.logo-img-wrap::after{
  content:'';position:absolute;inset:0;
  border-radius:7px;
  box-shadow:inset 0 0 12px rgba(0,210,255,0.15);
}

.nav-wordmark{display:flex;flex-direction:column;gap:0;}
.nav-wordmark strong{
  font-family:var(--font-hud);font-size:13px;font-weight:700;
  color:#fff;letter-spacing:0.12em;
}
.nav-wordmark span{
  font-family:var(--font-mono);font-size:9px;
  color:var(--cyan-dim);letter-spacing:0.15em;
  text-transform:uppercase;
}

.nav-center{
  display:flex;gap:2px;
  background:rgba(0,210,255,0.04);
  border:1px solid var(--border);
  border-radius:var(--r);padding:4px;
}
.nav-link{
  font-family:var(--font-mono);font-size:11px;font-weight:400;
  color:var(--text-dim);text-decoration:none;
  padding:6px 16px;border-radius:4px;
  transition:all 0.2s;letter-spacing:0.08em;
}
.nav-link:hover{color:var(--cyan);background:rgba(0,210,255,0.07);}

.nav-right{display:flex;align-items:center;gap:10px;}

.status-pill{
  display:flex;align-items:center;gap:7px;
  background:rgba(0,255,157,0.06);
  border:1px solid rgba(0,255,157,0.2);
  border-radius:100px;padding:5px 12px;
}
.status-dot{width:6px;height:6px;border-radius:50%;background:var(--green);animation:pulse-dot 2s ease infinite;}
@keyframes pulse-dot{0%,100%{opacity:1;box-shadow:0 0 0 0 rgba(0,255,157,0.4);}50%{opacity:.8;box-shadow:0 0 0 4px rgba(0,255,157,0);}}
.status-text{font-family:var(--font-mono);font-size:10px;color:var(--green-dim);letter-spacing:.08em;}

.btn-access{
  font-family:var(--font-hud);font-size:10px;font-weight:600;
  letter-spacing:.12em;text-transform:uppercase;
  color:var(--void);background:var(--cyan);
  border:none;border-radius:var(--r);
  padding:10px 20px;cursor:none;text-decoration:none;
  transition:all 0.2s;
  box-shadow:0 0 20px rgba(0,210,255,0.3);
  position:relative;overflow:hidden;
}
.btn-access::before{
  content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(255,255,255,0.25),transparent);
  transition:left 0.4s;
}
.btn-access:hover{box-shadow:0 0 35px rgba(0,210,255,0.55);transform:translateY(-1px);}
.btn-access:hover::before{left:100%;}

/* ── HERO ── */
.hero{
  min-height:100vh;
  display:flex;align-items:center;
  padding:80px 3% 60px;
  position:relative;z-index:1;
}

.hero-inner{
  max-width:1280px;margin:0 auto;width:100%;
  display:grid;grid-template-columns:1fr 1fr;
  align-items:center;gap:80px;
}

.hero-left{}

.hero-tag{
  display:inline-flex;align-items:center;gap:8px;
  font-family:var(--font-mono);font-size:11px;
  color:var(--amber-dim);letter-spacing:.15em;text-transform:uppercase;
  border:1px solid rgba(255,149,0,0.25);
  background:rgba(255,149,0,0.06);
  border-radius:4px;padding:6px 12px;margin-bottom:28px;
}
.hero-tag::before{content:'▶';font-size:8px;}

.hero-title{
  font-family:var(--font-hud);
  font-size:clamp(36px,5vw,72px);
  font-weight:900;line-height:1;
  letter-spacing:-0.02em;
  margin-bottom:20px;
}
.hero-title .line1{
  display:block;color:#fff;
  text-shadow:0 0 40px rgba(255,255,255,0.2);
}
.hero-title .line2{
  display:block;
  background:linear-gradient(90deg,var(--cyan),rgba(0,210,255,0.5));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  filter:drop-shadow(0 0 20px rgba(0,210,255,0.5));
}
.hero-title .line3{
  display:block;color:rgba(255,255,255,0.2);font-size:0.45em;
  letter-spacing:.3em;font-weight:400;margin-top:8px;
  -webkit-text-fill-color:initial;
}

.hero-desc{
  font-size:16px;line-height:1.8;color:var(--text-dim);
  max-width:460px;margin-bottom:40px;
  border-left:2px solid rgba(0,210,255,0.2);
  padding-left:16px;
}

.hero-actions{display:flex;gap:14px;flex-wrap:wrap;align-items:center;}

.btn-primary-hero{
  font-family:var(--font-hud);font-size:11px;font-weight:700;
  letter-spacing:.12em;text-transform:uppercase;
  color:var(--void);background:var(--cyan);
  border:none;border-radius:var(--r);cursor:none;
  padding:16px 32px;text-decoration:none;
  display:inline-flex;align-items:center;gap:10px;
  box-shadow:0 0 30px rgba(0,210,255,0.35);
  transition:all 0.2s;position:relative;overflow:hidden;
}
.btn-primary-hero:hover{
  transform:translateY(-3px);
  box-shadow:0 0 50px rgba(0,210,255,0.55),0 8px 20px rgba(0,0,0,0.4);
}
.btn-primary-hero svg{transition:transform 0.2s;}
.btn-primary-hero:hover svg{transform:translateX(4px);}

.btn-ghost-hero{
  font-family:var(--font-mono);font-size:12px;font-weight:400;
  letter-spacing:.08em;
  color:var(--text-dim);background:transparent;
  border:1px solid var(--border);
  border-radius:var(--r);cursor:none;
  padding:15px 28px;text-decoration:none;
  display:inline-flex;align-items:center;gap:10px;
  transition:all 0.2s;
}
.btn-ghost-hero:hover{
  color:var(--cyan);border-color:var(--border-bright);
  background:rgba(0,210,255,0.05);
  transform:translateY(-2px);
}

.hero-meta{
  display:flex;gap:24px;margin-top:40px;
  padding-top:28px;
  border-top:1px solid var(--border);
}
.meta-item{}
.meta-num{
  font-family:var(--font-hud);font-size:22px;font-weight:700;color:#fff;
  line-height:1;
}
.meta-num span{color:var(--cyan);}
.meta-label{font-family:var(--font-mono);font-size:10px;color:var(--text-muted);letter-spacing:.1em;margin-top:4px;}

/* ── HERO RIGHT — HUD PANEL ── */
.hud-panel{
  background:var(--panel);
  border:1px solid var(--border);
  border-radius:12px;
  padding:24px;
  position:relative;
  overflow:hidden;
}
.hud-panel::before{
  content:'';position:absolute;top:0;left:0;right:0;height:1px;
  background:linear-gradient(90deg,transparent,var(--cyan),transparent);
}
.hud-panel::after{
  content:'';position:absolute;
  inset:0;border-radius:12px;
  box-shadow:inset 0 0 60px rgba(0,210,255,0.04);
  pointer-events:none;
}

.hud-header{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:20px;padding-bottom:16px;
  border-bottom:1px solid var(--border);
}
.hud-title{
  font-family:var(--font-hud);font-size:10px;font-weight:600;
  color:var(--cyan-dim);letter-spacing:.2em;text-transform:uppercase;
}
.hud-status{
  display:flex;align-items:center;gap:5px;
  font-family:var(--font-mono);font-size:9px;color:var(--green-dim);
}
.hud-status-dot{width:5px;height:5px;border-radius:50%;background:var(--green);animation:pulse-dot 2s infinite;}

.inventory-list{display:flex;flex-direction:column;gap:8px;margin-bottom:20px;}

.inv-row{
  display:grid;grid-template-columns:1fr auto auto;align-items:center;gap:16px;
  background:rgba(0,210,255,0.03);
  border:1px solid rgba(0,210,255,0.07);
  border-radius:var(--r);padding:10px 14px;
  transition:all 0.2s;
}
.inv-row:hover{border-color:rgba(0,210,255,0.2);background:rgba(0,210,255,0.07);}

.inv-name{font-size:12px;font-weight:500;color:var(--text);}
.inv-id{font-family:var(--font-mono);font-size:9px;color:var(--text-muted);}

.inv-bar-wrap{width:80px;}
.inv-bar-bg{height:3px;background:rgba(0,210,255,0.1);border-radius:2px;overflow:hidden;}
.inv-bar-fill{height:100%;border-radius:2px;transition:width 0.8s ease;}
.inv-bar-fill.high{background:var(--green);}
.inv-bar-fill.med{background:var(--amber);}
.inv-bar-fill.low{background:#ff4d6d;}

.inv-count{
  font-family:var(--font-mono);font-size:11px;font-weight:500;
  color:var(--text);min-width:36px;text-align:right;
}
.inv-badge{
  font-family:var(--font-mono);font-size:8px;letter-spacing:.08em;
  padding:3px 7px;border-radius:3px;text-transform:uppercase;
}
.inv-badge.available{color:var(--green);background:rgba(0,255,157,0.08);border:1px solid rgba(0,255,157,0.2);}
.inv-badge.lent{color:var(--amber);background:rgba(255,149,0,0.08);border:1px solid rgba(255,149,0,0.2);}
.inv-badge.maintenance{color:#ff4d6d;background:rgba(255,77,109,0.08);border:1px solid rgba(255,77,109,0.2);}

.hud-chart{
  background:rgba(0,0,0,0.2);border-radius:var(--r);
  border:1px solid var(--border);padding:14px;
  margin-bottom:16px;
}
.chart-label{
  font-family:var(--font-mono);font-size:9px;color:var(--text-muted);
  letter-spacing:.12em;margin-bottom:10px;text-transform:uppercase;
}
.chart-bars{display:flex;align-items:flex-end;gap:4px;height:50px;}
.chart-bar{
  flex:1;border-radius:2px 2px 0 0;
  background:linear-gradient(0deg,var(--cyan),rgba(0,210,255,0.3));
  min-height:4px;transition:height 0.5s ease;
  position:relative;cursor:none;
}
.chart-bar:hover{background:linear-gradient(0deg,#fff,var(--cyan));}
.chart-days{display:flex;gap:4px;margin-top:5px;}
.chart-day{flex:1;text-align:center;font-family:var(--font-mono);font-size:8px;color:var(--text-muted);}

.hud-footer-row{
  display:grid;grid-template-columns:1fr 1fr;gap:10px;
}
.hud-mini-stat{
  background:rgba(0,210,255,0.04);
  border:1px solid var(--border);border-radius:var(--r);
  padding:10px 12px;
}
.hud-mini-val{
  font-family:var(--font-hud);font-size:18px;font-weight:700;
  color:#fff;line-height:1;
}
.hud-mini-val.cyan{color:var(--cyan);}
.hud-mini-label{font-family:var(--font-mono);font-size:9px;color:var(--text-muted);margin-top:4px;letter-spacing:.08em;}

/* ── TICKER ── */
.ticker-wrap{
  position:relative;z-index:1;
  background:rgba(0,210,255,0.04);
  border-top:1px solid var(--border);
  border-bottom:1px solid var(--border);
  padding:10px 0;overflow:hidden;
}
.ticker-inner{
  display:flex;gap:0;
  animation:ticker 25s linear infinite;
  white-space:nowrap;
}
.ticker-item{
  font-family:var(--font-mono);font-size:11px;color:var(--text-muted);
  padding:0 32px;letter-spacing:.06em;
}
.ticker-item span{color:var(--cyan-dim);}
@keyframes ticker{0%{transform:translateX(0);}100%{transform:translateX(-50%);}}

/* ── SECTION BASE ── */
.section{padding:100px 3%;position:relative;z-index:1;}
.section-inner{max-width:1200px;margin:0 auto;}

.eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  font-family:var(--font-mono);font-size:10px;color:var(--cyan-dim);
  letter-spacing:.2em;text-transform:uppercase;margin-bottom:16px;
}
.eyebrow::before{content:'//';opacity:.5;}

.section-title{
  font-family:var(--font-hud);font-size:clamp(28px,3.5vw,48px);
  font-weight:800;line-height:1.1;letter-spacing:-.02em;color:#fff;
  margin-bottom:16px;
}
.section-title em{
  font-style:normal;
  background:linear-gradient(90deg,var(--cyan),var(--green-dim));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.section-sub{
  font-size:16px;color:var(--text-dim);line-height:1.7;
  max-width:520px;
}

/* ── FLOW SECTION ── */
.flow-section{background:var(--deep);}
.flow-header{text-align:center;max-width:600px;margin:0 auto 64px;}
.flow-header .section-sub{margin:0 auto;}

.flow-grid{
  display:grid;grid-template-columns:repeat(4,1fr);gap:1px;
  background:var(--border);
  border:1px solid var(--border);border-radius:12px;
  overflow:hidden;
}

.flow-card{
  background:var(--panel);
  padding:32px 24px;
  position:relative;
  transition:all 0.3s;
  overflow:hidden;
}
.flow-card::before{
  content:'';position:absolute;
  top:0;left:0;right:0;height:2px;
  background:linear-gradient(90deg,var(--cyan),transparent);
  transform:scaleX(0);transform-origin:left;
  transition:transform 0.4s ease;
}
.flow-card:hover{background:rgba(0,210,255,0.04);}
.flow-card:hover::before{transform:scaleX(1);}

.flow-num{
  font-family:var(--font-hud);font-size:56px;font-weight:900;
  color:rgba(0,210,255,0.06);line-height:1;
  position:absolute;top:16px;right:16px;
  transition:color 0.3s;
}
.flow-card:hover .flow-num{color:rgba(0,210,255,0.12);}

.flow-icon-box{
  width:48px;height:48px;border-radius:10px;
  background:rgba(0,210,255,0.06);
  border:1px solid rgba(0,210,255,0.15);
  display:flex;align-items:center;justify-content:center;
  margin-bottom:20px;
  transition:all 0.3s;
}
.flow-card:hover .flow-icon-box{
  background:rgba(0,210,255,0.12);
  border-color:rgba(0,210,255,0.35);
  box-shadow:0 0 20px rgba(0,210,255,0.15);
}

.flow-card h3{
  font-family:var(--font-hud);font-size:13px;font-weight:600;
  color:#fff;letter-spacing:.05em;margin-bottom:10px;
}
.flow-card p{font-size:13px;color:var(--text-dim);line-height:1.7;}

/* ── FEATURES ── */
.features-section{background:var(--void);}

.feat-layout{
  display:grid;grid-template-columns:1fr 2fr;
  gap:64px;align-items:start;
}

.feat-left{position:sticky;top:100px;}
.feat-left .section-sub{margin-bottom:32px;}

.feat-terminal{
  background:var(--panel);
  border:1px solid var(--border);border-radius:10px;
  overflow:hidden;
}
.terminal-bar{
  display:flex;align-items:center;gap:6px;
  padding:10px 16px;
  background:rgba(0,0,0,0.3);
  border-bottom:1px solid var(--border);
}
.terminal-dot{width:10px;height:10px;border-radius:50%;}
.terminal-dot:nth-child(1){background:#ff5f57;}
.terminal-dot:nth-child(2){background:#ffbd2e;}
.terminal-dot:nth-child(3){background:#28c840;}
.terminal-title{
  font-family:var(--font-mono);font-size:10px;
  color:var(--text-muted);margin:0 auto;letter-spacing:.1em;
}
.terminal-body{padding:16px;font-family:var(--font-mono);font-size:12px;line-height:2;}
.t-comment{color:rgba(0,210,255,0.35);}
.t-key{color:var(--amber-dim);}
.t-val{color:var(--green-dim);}
.t-str{color:rgba(255,149,0,0.8);}
.t-num{color:var(--cyan-dim);}
.t-cursor{
  display:inline-block;width:8px;height:14px;
  background:var(--cyan);vertical-align:middle;
  animation:blink 1.2s step-end infinite;
}
@keyframes blink{0%,100%{opacity:1;}50%{opacity:0;}}

.feat-grid{display:flex;flex-direction:column;gap:16px;}

.feat-card{
  background:var(--panel);
  border:1px solid var(--border);
  border-radius:10px;padding:24px 28px;
  display:grid;grid-template-columns:auto 1fr auto;gap:20px;align-items:start;
  transition:all 0.3s;position:relative;overflow:hidden;
}
.feat-card::after{
  content:'';position:absolute;left:0;top:0;bottom:0;width:2px;
  background:var(--cyan);transform:scaleY(0);transform-origin:top;
  transition:transform 0.3s;
}
.feat-card:hover{border-color:var(--border-bright);background:rgba(0,210,255,0.03);}
.feat-card:hover::after{transform:scaleY(1);}

.feat-card-icon{
  width:44px;height:44px;border-radius:8px;
  background:rgba(0,210,255,0.06);
  border:1px solid rgba(0,210,255,0.12);
  display:flex;align-items:center;justify-content:center;
  flex-shrink:0;transition:all 0.3s;
}
.feat-card:hover .feat-card-icon{
  background:rgba(0,210,255,0.12);
  border-color:var(--border-bright);
  box-shadow:0 0 16px rgba(0,210,255,0.2);
}

.feat-card h3{
  font-family:var(--font-hud);font-size:13px;font-weight:600;
  color:#fff;letter-spacing:.04em;margin-bottom:8px;
}
.feat-card p{font-size:13px;color:var(--text-dim);line-height:1.7;}

.feat-tag{
  font-family:var(--font-mono);font-size:9px;letter-spacing:.1em;
  padding:4px 10px;border-radius:3px;
  color:var(--cyan-dim);
  background:rgba(0,210,255,0.06);
  border:1px solid rgba(0,210,255,0.15);
  white-space:nowrap;align-self:start;
}

/* ── STATS SECTION ── */
.stats-section{
  background:var(--deep);
  border-top:1px solid var(--border);
  border-bottom:1px solid var(--border);
}
.stats-grid{
  display:grid;grid-template-columns:repeat(4,1fr);
  gap:1px;background:var(--border);
  border:1px solid var(--border);border-radius:12px;
  overflow:hidden;
}
.stat-block{
  background:var(--panel);
  padding:36px 28px;text-align:center;
  position:relative;overflow:hidden;
  transition:background 0.3s;
}
.stat-block:hover{background:rgba(0,210,255,0.04);}
.stat-block::before{
  content:'';position:absolute;
  bottom:0;left:50%;transform:translateX(-50%);
  width:40%;height:1px;
  background:linear-gradient(90deg,transparent,var(--cyan),transparent);
}
.stat-n{
  font-family:var(--font-hud);font-size:48px;font-weight:900;
  color:#fff;line-height:1;letter-spacing:-0.03em;
}
.stat-n span{color:var(--cyan);}
.stat-unit{font-family:var(--font-hud);font-size:20px;color:var(--cyan);}
.stat-l{
  font-family:var(--font-mono);font-size:11px;
  color:var(--text-muted);letter-spacing:.12em;
  text-transform:uppercase;margin-top:10px;
}

/* ── CTA ── */
.cta-section{background:var(--void);padding:120px 3%;}
.cta-box{
  max-width:900px;margin:0 auto;
  position:relative;
  background:var(--panel);
  border:1px solid var(--border-bright);
  border-radius:16px;
  padding:72px 64px;
  text-align:center;
  overflow:hidden;
}
.cta-box::before{
  content:'';position:absolute;top:0;left:0;right:0;height:1px;
  background:linear-gradient(90deg,transparent,var(--cyan),var(--green),transparent);
}
.cta-glow{
  position:absolute;top:50%;left:50%;
  transform:translate(-50%,-50%);
  width:500px;height:200px;
  background:radial-gradient(ellipse,rgba(0,210,255,0.07) 0%,transparent 70%);
  pointer-events:none;
}
.cta-eyebrow{
  font-family:var(--font-mono);font-size:10px;color:var(--amber-dim);
  letter-spacing:.2em;text-transform:uppercase;margin-bottom:20px;
}
.cta-title{
  font-family:var(--font-hud);font-size:clamp(28px,4vw,52px);
  font-weight:900;color:#fff;line-height:1.1;
  letter-spacing:-0.02em;margin-bottom:20px;
}
.cta-title em{
  font-style:normal;color:var(--cyan);
  filter:drop-shadow(0 0 15px rgba(0,210,255,0.5));
}
.cta-sub{
  font-size:16px;color:var(--text-dim);line-height:1.7;
  max-width:480px;margin:0 auto 40px;
}
.cta-actions{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;}

.btn-cta-primary{
  font-family:var(--font-hud);font-size:11px;font-weight:700;
  letter-spacing:.12em;text-transform:uppercase;
  color:var(--void);background:var(--cyan);
  border:none;border-radius:var(--r);cursor:none;
  padding:18px 40px;text-decoration:none;
  display:inline-flex;align-items:center;gap:10px;
  box-shadow:0 0 40px rgba(0,210,255,0.4);
  transition:all 0.3s;
}
.btn-cta-primary:hover{transform:translateY(-3px);box-shadow:0 0 60px rgba(0,210,255,0.6);}

.btn-cta-ghost{
  font-family:var(--font-mono);font-size:12px;
  color:var(--text-dim);background:transparent;
  border:1px solid var(--border);
  border-radius:var(--r);cursor:none;
  padding:17px 32px;text-decoration:none;
  display:inline-flex;align-items:center;gap:8px;
  transition:all 0.3s;
}
.btn-cta-ghost:hover{color:var(--cyan);border-color:var(--border-bright);background:rgba(0,210,255,0.05);}

/* ── FOOTER ── */
footer{
  background:var(--deep);
  border-top:1px solid var(--border);
  padding:64px 3% 32px;
  position:relative;z-index:1;
}
.footer-grid{
  max-width:1200px;margin:0 auto;
  display:grid;grid-template-columns:2fr 1fr 1fr 1fr;
  gap:48px;margin-bottom:48px;
}

.footer-brand-col .brand-logo{
  display:flex;align-items:center;gap:14px;margin-bottom:20px;
}
.footer-logo-mark{
  width:40px;height:40px;border-radius:8px;
  background:rgba(0,210,255,0.06);
  border:1px solid rgba(0,210,255,0.2);
  display:flex;align-items:center;justify-content:center;
  overflow:hidden;
}
.footer-logo-mark img{width:100%;height:100%;object-fit:cover;}
.footer-logo-mark-ph{
  font-family:var(--font-hud);font-size:9px;
  color:var(--cyan-dim);text-align:center;line-height:1.2;padding:4px;
}
.footer-wordmark strong{
  font-family:var(--font-hud);font-size:13px;font-weight:700;
  color:#fff;letter-spacing:.1em;display:block;
}
.footer-wordmark em{
  font-family:var(--font-mono);font-size:9px;font-style:normal;
  color:var(--text-muted);letter-spacing:.12em;
}

.footer-brand-col p{
  font-size:13px;color:var(--text-dim);line-height:1.8;
  max-width:280px;margin-bottom:20px;
}
.footer-contact-links{display:flex;flex-direction:column;gap:8px;}
.footer-contact-links a{
  font-family:var(--font-mono);font-size:12px;color:var(--text-muted);
  text-decoration:none;transition:color 0.2s;
}
.footer-contact-links a:hover{color:var(--cyan);}

.footer-col h4{
  font-family:var(--font-hud);font-size:9px;font-weight:600;
  color:var(--cyan-dim);letter-spacing:.2em;
  text-transform:uppercase;margin-bottom:20px;
}
.footer-links{list-style:none;display:flex;flex-direction:column;gap:10px;}
.footer-links a{
  font-size:13px;color:var(--text-dim);text-decoration:none;
  transition:color 0.2s;display:inline-flex;align-items:center;gap:6px;
}
.footer-links a::before{content:'—';font-size:10px;color:var(--text-muted);}
.footer-links a:hover{color:var(--cyan);}

.footer-address{
  font-family:var(--font-mono);font-size:11px;color:var(--text-dim);
  line-height:2;margin-bottom:20px;
}

.social-row{display:flex;gap:8px;margin-top:8px;}
.social-btn{
  width:32px;height:32px;border-radius:6px;
  background:rgba(0,210,255,0.05);
  border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  font-family:var(--font-mono);font-size:11px;
  color:var(--text-muted);text-decoration:none;
  transition:all 0.2s;
}
.social-btn:hover{
  background:rgba(0,210,255,0.1);
  border-color:var(--border-bright);
  color:var(--cyan);transform:translateY(-2px);
  box-shadow:0 0 12px rgba(0,210,255,0.2);
}

.footer-bottom{
  max-width:1200px;margin:0 auto;
  display:flex;justify-content:space-between;align-items:center;
  padding-top:24px;border-top:1px solid var(--border);
  flex-wrap:wrap;gap:10px;
}
.footer-bottom span{
  font-family:var(--font-mono);font-size:11px;color:var(--text-muted);
  letter-spacing:.05em;
}
.footer-bottom .version{color:var(--cyan-dim);}

/* ── SCROLL REVEAL ── */
.reveal{opacity:0;transform:translateY(30px);transition:opacity 0.7s ease,transform 0.7s ease;}
.reveal.in{opacity:1;transform:none;}

/* ── RESPONSIVE ── */
@media(max-width:1024px){
  .hero-inner{grid-template-columns:1fr;gap:48px;}
  .feat-layout{grid-template-columns:1fr;}
  .feat-left{position:static;}
  .footer-grid{grid-template-columns:1fr 1fr;}
  .flow-grid{grid-template-columns:repeat(2,1fr);}
  nav .nav-center{display:none;}
}
@media(max-width:768px){
  .stats-grid{grid-template-columns:repeat(2,1fr);}
  .footer-grid{grid-template-columns:1fr;}
  .cta-box{padding:48px 28px;}
  .hero-meta{flex-wrap:wrap;gap:20px;}
}
@media(max-width:500px){
  .flow-grid{grid-template-columns:1fr;}
  .stats-grid{grid-template-columns:1fr;}
  .hud-panel{padding:16px;}
  nav{padding:0 4%;}
}
</style>
</head>
<body>

<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursor-ring"></div>
<div class="grid-bg"></div>
<div class="scanline"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<!-- ── NAV ── -->
<nav>
  <a class="nav-logo" href="#">
    <div class="logo-img-wrap">
      <img src="{{ asset('images/wikrama-logo.png') }}" alt="SMK Wikrama" 
           onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
      <!-- <div class="logo-img-placeholder" style="display:flex;flex-direction:column;align-items:center;">
        <span>IMG</span>
        <span>HERE</span>
      </div> -->
    </div>
    <div class="nav-wordmark">
      <strong>SMK WIKRAMA</strong>
      <span>Inventaris System</span>
    </div>
  </a>

  <div class="nav-center">
    <a class="nav-link" href="#flow">// workflow</a>
    <a class="nav-link" href="#features">// features</a>
    <a class="nav-link" href="#footer">// contact</a>
  </div>

  <div class="nav-right">
    <div class="status-pill">
      <div class="status-dot"></div>
      <span class="status-text">SYS_ONLINE</span>
    </div>
    <a href="{{ route('filament.admin.auth.login')}}" class="btn-access">Login</a>
  </div>
</nav>

<!-- ── HERO ── -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-left reveal">
      <div class="hero-tag">SMK Wikrama Bogor · Inventory Management</div>
      <h1 class="hero-title">
        <span class="line1">INVENTORY</span>
        <span class="line2">MANAGEMENT</span>
        <span class="line3">SYSTEM v2.0 · WIKRAMA · 2025</span>
      </h1>
      <p class="hero-desc">
        Sistem manajemen inventaris digital SMK Wikrama Bogor — real-time tracking, peminjaman transparan, dan laporan akurat dalam satu platform terpadu.
      </p>
      <div class="hero-actions">
        <a href="{{ route('filament.admin.auth.login')}}" class="btn-primary-hero">
          <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          Akses Sistem
        </a>
        <a href="#flow" class="btn-ghost-hero">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M10 8l6 4-6 4V8z"/></svg>
          Cara Kerja
        </a>
      </div>
      <div class="hero-meta">
        <div class="meta-item">
          <div class="meta-num">500<span>+</span></div>
          <div class="meta-label">// items tracked</div>
        </div>
        <div class="meta-item">
          <div class="meta-num">120<span>+</span></div>
          <div class="meta-label">// active users</div>
        </div>
        <div class="meta-item">
          <div class="meta-num">98<span>%</span></div>
          <div class="meta-label">// accuracy rate</div>
        </div>
        <div class="meta-item">
          <div class="meta-num">24<span>/7</span></div>
          <div class="meta-label">// uptime</div>
        </div>
      </div>
    </div>

    <!-- HUD PANEL -->
    <div class="hud-panel reveal" style="transition-delay:0.15s;">
      <div class="hud-header">
        <span class="hud-title">// Live Inventory Feed</span>
        <span class="hud-status"><div class="hud-status-dot"></div> LIVE</span>
      </div>

      <div class="inventory-list">
        <div class="inv-row">
          <div>
            <div class="inv-name">Laptop Asus VivoBook</div>
            <div class="inv-id">SKU-0042</div>
          </div>
          <div>
            <div class="inv-bar-wrap">
              <div class="inv-bar-bg"><div class="inv-bar-fill high" style="width:80%"></div></div>
            </div>
          </div>
          <div>
            <div class="inv-count">24/30</div>
            <div class="inv-badge available">Available</div>
          </div>
        </div>
        <div class="inv-row">
          <div>
            <div class="inv-name">Proyektor Epson X39</div>
            <div class="inv-id">SKU-0017</div>
          </div>
          <div>
            <div class="inv-bar-wrap">
              <div class="inv-bar-bg"><div class="inv-bar-fill med" style="width:45%"></div></div>
            </div>
          </div>
          <div>
            <div class="inv-count">5/11</div>
            <div class="inv-badge lent">Lent</div>
          </div>
        </div>
        <div class="inv-row">
          <div>
            <div class="inv-name">Kabel HDMI 2.0</div>
            <div class="inv-id">SKU-0093</div>
          </div>
          <div>
            <div class="inv-bar-wrap">
              <div class="inv-bar-bg"><div class="inv-bar-fill high" style="width:90%"></div></div>
            </div>
          </div>
          <div>
            <div class="inv-count">45/50</div>
            <div class="inv-badge available">Available</div>
          </div>
        </div>
        <div class="inv-row">
          <div>
            <div class="inv-name">Toolkit Elektronik</div>
            <div class="inv-id">SKU-0031</div>
          </div>
          <div>
            <div class="inv-bar-wrap">
              <div class="inv-bar-bg"><div class="inv-bar-fill low" style="width:20%"></div></div>
            </div>
          </div>
          <div>
            <div class="inv-count">2/10</div>
            <div class="inv-badge maintenance">Service</div>
          </div>
        </div>
      </div>

      <div class="hud-chart">
        <div class="chart-label">// Peminjaman 7 Hari Terakhir</div>
        <div class="chart-bars" id="chart-bars">
          <div class="chart-bar" style="height:60%"></div>
          <div class="chart-bar" style="height:40%"></div>
          <div class="chart-bar" style="height:80%"></div>
          <div class="chart-bar" style="height:55%"></div>
          <div class="chart-bar" style="height:95%"></div>
          <div class="chart-bar" style="height:70%"></div>
          <div class="chart-bar" style="height:45%"></div>
        </div>
        <div class="chart-days">
          <span class="chart-day">Sen</span><span class="chart-day">Sel</span>
          <span class="chart-day">Rab</span><span class="chart-day">Kam</span>
          <span class="chart-day">Jum</span><span class="chart-day">Sab</span>
          <span class="chart-day">Min</span>
        </div>
      </div>

      <div class="hud-footer-row">
        <div class="hud-mini-stat">
          <div class="hud-mini-val cyan">12</div>
          <div class="hud-mini-label">// Peminjaman Aktif</div>
        </div>
        <div class="hud-mini-stat">
          <div class="hud-mini-val">3</div>
          <div class="hud-mini-label">// Pending Approval</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── TICKER ── -->
<div class="ticker-wrap">
  <div class="ticker-inner">
    <span class="ticker-item">SISTEM ONLINE <span>✓</span></span>
    <span class="ticker-item">TOTAL ITEM <span>500+</span></span>
    <span class="ticker-item">AKURASI DATA <span>98.4%</span></span>
    <span class="ticker-item">PENGGUNA AKTIF <span>120</span></span>
    <span class="ticker-item">PEMINJAMAN HARI INI <span>17</span></span>
    <span class="ticker-item">KATEGORI BARANG <span>24</span></span>
    <span class="ticker-item">BACKUP TERAKHIR <span>04:00 WIB</span></span>
    <span class="ticker-item">SMK WIKRAMA BOGOR <span>◆</span></span>
    <!-- repeat for seamless loop -->
    <span class="ticker-item">SISTEM ONLINE <span>✓</span></span>
    <span class="ticker-item">TOTAL ITEM <span>500+</span></span>
    <span class="ticker-item">AKURASI DATA <span>98.4%</span></span>
    <span class="ticker-item">PENGGUNA AKTIF <span>120</span></span>
    <span class="ticker-item">PEMINJAMAN HARI INI <span>17</span></span>
    <span class="ticker-item">KATEGORI BARANG <span>24</span></span>
    <span class="ticker-item">BACKUP TERAKHIR <span>04:00 WIB</span></span>
    <span class="ticker-item">SMK WIKRAMA BOGOR <span>◆</span></span>
  </div>
</div>

<!-- ── FLOW ── -->
<section class="section flow-section" id="flow">
  <div class="section-inner">
    <div class="flow-header reveal">
      <div class="eyebrow">workflow</div>
      <h2 class="section-title">Alur <em>Sistem</em></h2>
      <p class="section-sub">Empat langkah sederhana yang membuat inventaris tetap terorganisir, transparan, dan mudah diakses oleh seluruh warga SMK Wikrama.</p>
    </div>

    <div class="flow-grid reveal" style="transition-delay:0.1s;">
      <div class="flow-card">
        <div class="flow-num">01</div>
        <div class="flow-icon-box">
          <svg width="22" height="22" fill="none" stroke="var(--cyan)" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8m-4-4v4"/></svg>
        </div>
        <h3>Data Barang</h3>
        <p>Database terpusat semua item inventaris dengan kategori, kondisi, jumlah, dan status ketersediaan secara real-time.</p>
      </div>
      <div class="flow-card">
        <div class="flow-num">02</div>
        <div class="flow-icon-box">
          <svg width="22" height="22" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5.5 21a8.38 8.38 0 0115 0"/></svg>
        </div>
        <h3>Teknisi Pengelola</h3>
        <p>Teknisi khusus mengawasi penerimaan, pemeliharaan, dan penilaian kondisi barang untuk rekaman yang andal.</p>
      </div>
      <div class="flow-card">
        <div class="flow-num">03</div>
        <div class="flow-icon-box">
          <svg width="22" height="22" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        </div>
        <h3>Peminjaman Terkelola</h3>
        <p>Alur peminjaman terstruktur dengan persetujuan, penjadwalan, dan pelacakan pengembalian untuk mencegah kehilangan.</p>
      </div>
      <div class="flow-card">
        <div class="flow-num">04</div>
        <div class="flow-icon-box">
          <svg width="22" height="22" fill="none" stroke="var(--cyan)" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"/></svg>
        </div>
        <h3>Semua Bisa Pinjam</h3>
        <p>Siswa, guru, dan staf dapat dengan mudah melihat item tersedia dan mengajukan permintaan peminjaman.</p>
      </div>
    </div>
  </div>
</section>

<!-- ── FEATURES ── -->
<section class="section features-section" id="features">
  <div class="section-inner">
    <div class="feat-layout">
      <div class="feat-left reveal">
        <div class="eyebrow">features</div>
        <h2 class="section-title">Dibangun untuk <em>Efisiensi</em></h2>
        <p class="section-sub">Semua yang Anda butuhkan untuk mengelola inventaris sekolah — tanpa kerumitan. Dirancang untuk siswa dan staf.</p>

        <div class="feat-terminal" style="margin-top:32px;">
          <div class="terminal-bar">
            <div class="terminal-dot"></div>
            <div class="terminal-dot"></div>
            <div class="terminal-dot"></div>
            <span class="terminal-title">system_status.json</span>
          </div>
          <div class="terminal-body">
            <div><span class="t-comment">// Inventory System v2.0</span></div>
            <div><span class="t-key">"status"</span>: <span class="t-val">"operational"</span>,</div>
            <div><span class="t-key">"uptime"</span>: <span class="t-num">99.8</span>,</div>
            <div><span class="t-key">"total_items"</span>: <span class="t-num">524</span>,</div>
            <div><span class="t-key">"active_loans"</span>: <span class="t-num">12</span>,</div>
            <div><span class="t-key">"school"</span>: <span class="t-str">"SMK Wikrama"</span>,</div>
            <div><span class="t-key">"last_sync"</span>: <span class="t-str">"just now"</span> <span class="t-cursor"></span></div>
          </div>
        </div>
      </div>

      <div class="feat-grid">
        <div class="feat-card reveal">
          <div class="feat-card-icon">
            <svg width="20" height="20" fill="none" stroke="var(--cyan)" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          </div>
          <div>
            <h3>Real-Time Tracking</h3>
            <p>Pantau ketersediaan, lokasi, dan kondisi barang secara real-time. Tidak ada lagi pembaruan buku manual atau tebak-tebakan tentang ketersediaan.</p>
          </div>
          <div class="feat-tag">LIVE</div>
        </div>

        <div class="feat-card reveal" style="transition-delay:0.1s;">
          <div class="feat-card-icon">
            <svg width="20" height="20" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
          </div>
          <div>
            <h3>Sistem Peminjaman Mudah</h3>
            <p>Minta, setujui, dan kembalikan barang hanya dengan beberapa klik. Pengingat otomatis dan pelacakan tanggal jatuh tempo.</p>
          </div>
          <div class="feat-tag">AUTO</div>
        </div>

        <div class="feat-card reveal" style="transition-delay:0.2s;">
          <div class="feat-card-icon">
            <svg width="20" height="20" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          </div>
          <div>
            <h3>Manajemen Teknisi</h3>
            <p>Tugaskan teknisi ke kategori item, catat tugas perawatan, dan lacak riwayat servis — semua dalam satu dashboard.</p>
          </div>
          <div class="feat-tag">MGMT</div>
        </div>

        <div class="feat-card reveal" style="transition-delay:0.3s;">
          <div class="feat-card-icon">
            <svg width="20" height="20" fill="none" stroke="var(--cyan)" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
          </div>
          <div>
            <h3>Dashboard Laporan</h3>
            <p>Hasilkan laporan terperinci tentang frekuensi peminjaman, kondisi barang, dan tren inventaris untuk pengambilan keputusan lebih baik.</p>
          </div>
          <div class="feat-tag">ANALYTICS</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── STATS ── -->
<section class="section stats-section">
  <div class="section-inner">
    <div class="stats-grid reveal">
      <div class="stat-block">
        <div class="stat-n">500<span class="stat-unit">+</span></div>
        <div class="stat-l">// Items Inventaris</div>
      </div>
      <div class="stat-block">
        <div class="stat-n">120<span class="stat-unit">+</span></div>
        <div class="stat-l">// Pengguna Aktif</div>
      </div>
      <div class="stat-block">
        <div class="stat-n">98<span class="stat-unit">%</span></div>
        <div class="stat-l">// Tingkat Akurasi</div>
      </div>
      <div class="stat-block">
        <div class="stat-n">24<span class="stat-unit">/7</span></div>
        <div class="stat-l">// System Uptime</div>
      </div>
    </div>
  </div>
</section>

<!-- ── CTA ── -->
<section class="cta-section">
  <div class="cta-box reveal">
    <div class="cta-glow"></div>
    <div class="cta-eyebrow">▶ Ready to initialize</div>
    <h2 class="cta-title">Siap untuk<br><em>Memulai?</em></h2>
    <p class="cta-sub">Bergabunglah dengan sistem inventaris digital SMK Wikrama — cepat, sederhana, dan transparan untuk seluruh komunitas sekolah.</p>
    <div class="cta-actions">
      <a href="{{ route('filament.admin.auth.login')}}" class="btn-cta-primary">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        Akses Sistem Sekarang
      </a>
      <a href="#flow" class="btn-cta-ghost">Pelajari Lebih Lanjut</a>
    </div>
  </div>
</section>

<!-- ── FOOTER ── -->
<footer id="footer">
  <div class="footer-grid">
    <div class="footer-brand-col">
      <div class="brand-logo">
        <!-- IMAGE SLOT for footer logo -->
        <div class="footer-logo-mark">
          <img src="" alt="SMK Wikrama"
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex';"/>
          <div class="footer-logo-mark-ph" style="display:none;flex-direction:column;align-items:center;">IMG</div>
        </div>
        <div class="footer-wordmark">
          <strong>SMK WIKRAMA</strong>
          <em>Inventory System · v2.0</em>
        </div>
      </div>
      <p>Digitalisasi manajemen inventaris SMK Wikrama Bogor — transparan, efisien, dan mudah diakses oleh seluruh komunitas sekolah.</p>
      <div class="footer-contact-links">
        <a href="mailto:smkwikrama@sch.id">smkwikrama@sch.id</a>
        <a href="tel:001-7878-2878">001-7878-2878</a>
      </div>
    </div>

    <div class="footer-col">
      <h4>Guidelines</h4>
      <ul class="footer-links">
        <li><a href="#">Terms of Service</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Cookie Policy</a></li>
        <li><a href="#">Help Center</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Navigation</h4>
      <ul class="footer-links">
        <li><a href="#flow">Workflow</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#">Login</a></li>
        <li><a href="#footer">Contact</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Location</h4>
      <div class="footer-address">
        Jalan Wangun Tengah<br>
        Sindangsari<br>
        Jawa Barat, Indonesia
      </div>
      <div class="social-row">
        <a class="social-btn" href="#" title="Facebook">f</a>
        <a class="social-btn" href="#" title="X">𝕏</a>
        <a class="social-btn" href="#" title="Instagram">ig</a>
        <a class="social-btn" href="#" title="LinkedIn">in</a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <span>© 2025 SMK Wikrama Bogor. All rights reserved.</span>
    <span class="version">INVNTRY · v2.0.0 · BUILD_20250413</span>
  </div>
</footer>

<script>
// Custom cursor
const cursor = document.getElementById('cursor');
const ring = document.getElementById('cursor-ring');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{
  mx=e.clientX;my=e.clientY;
  cursor.style.left=mx+'px';cursor.style.top=my+'px';
});
function animRing(){
  rx+=(mx-rx)*0.12;ry+=(my-ry)*0.12;
  ring.style.left=rx+'px';ring.style.top=ry+'px';
  requestAnimationFrame(animRing);
}animRing();
document.querySelectorAll('a,button').forEach(el=>{
  el.addEventListener('mouseenter',()=>{
    cursor.style.width='6px';cursor.style.height='6px';
    ring.style.width='52px';ring.style.height='52px';
  });
  el.addEventListener('mouseleave',()=>{
    cursor.style.width='12px';cursor.style.height='12px';
    ring.style.width='36px';ring.style.height='36px';
  });
});

// Scroll reveal
const obs = new IntersectionObserver(entries=>{
  entries.forEach(e=>{
    if(e.isIntersecting) e.target.classList.add('in');
  });
},{threshold:0.1});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));

// Animate chart bars on view
const chartBars=document.querySelectorAll('.chart-bar');
const heights=['60%','40%','80%','55%','95%','70%','45%'];
chartBars.forEach((b,i)=>{
  b.style.height='0%';
  setTimeout(()=>{b.style.height=heights[i];b.style.transition='height 0.8s cubic-bezier(.4,0,.2,1)';},400+i*80);
});
</script>
</body>
</html>