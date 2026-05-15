Read PROJECT_CONTEXT/PHASE2_CONTEXT.md first before analyzing the codebase.

CRITICAL WORKFLOW RULES:

You are working in an incremental, resumable analysis workflow.

The goal is:

* analyze the project PER FILE
* trace connected dependencies
* continuously update the report markdown
* preserve progress even if session/token ends unexpectedly

DO NOT wait until all files are analyzed before writing the report.

Instead:

* after EACH file analysis,
* IMMEDIATELY update the report markdown with findings.

This ensures continuity for future sessions.

PRIMARY TASK:
Create and continuously maintain:

PROJECT_CONTEXT/PHASE2_STATUS_REPORT.md

WORKFLOW:

1. Read one file
2. Trace ALL connected files
3. Read connected files before making conclusions
4. Analyze:

   * architecture
   * dependencies
   * runtime risks
   * missing implementations
   * broken connections
   * inconsistencies
5. IMMEDIATELY append/update findings inside PHASE2_STATUS_REPORT.md
6. Mark analyzed files
7. Track pending files
8. Record next recommended file to analyze
9. Continue incrementally

IMPORTANT:
Never rely on memory alone.
Always persist progress into the markdown report.

FOR EVERY ANALYZED FILE INCLUDE:

# FILE ANALYSIS

File:

* exact filename/path

Connected Files:

* exact filenames

Purpose:

* what this file does

Current Status:

* working / incomplete / broken / risky

Issues Found:

* exact issues detected

Possible Runtime Risks:

* exact possible errors/problems

Needs Changes?

* yes/no

Why Changes Are Needed:

* detailed explanation

Affected Connected Files:

* exact filenames

Dependencies Required:

* files/modules this depends on

Safe Fix Priority:

* low / medium / high / critical

Recommended Fix Notes:

* planning only
* NO CODE YET

At the end of EVERY update inside the markdown:

## ANALYSIS PROGRESS

Completed Analysis:

* list completed files

Pending Analysis:

* list remaining files

Currently Blocked By:

* missing files/dependencies if any

Next Recommended File To Analyze:

* exact filename

Reason:

* why this should be analyzed next

IMPORTANT RULES:

* DO NOT MODIFY SOURCE CODE YET
* DO NOT GENERATE FIXES YET
* DO NOT SKIP CONNECTED FILES
* DO NOT ASSUME IMPLEMENTATIONS
* VERIFY REAL CONNECTIONS FIRST
* UPDATE THE MARKDOWN AFTER EVERY FILE ANALYSIS
* MAKE THE REPORT RESUMABLE FOR FUTURE AI SESSIONS

The markdown report should become the SINGLE SOURCE OF TRUTH for:

* completed analysis
* pending analysis
* dependency tracking
* debugging plan
* continuation workflow
* future implementation planning

If session/token ends:
future sessions must be able to continue ONLY by reading:
PROJECT_CONTEXT/PHASE2_STATUS_REPORT.md
